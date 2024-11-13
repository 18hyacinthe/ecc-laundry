<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminHistoriqueReservationDataTable;
use App\Models\Reservation;
use App\Models\Setting;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationNotification;

class AdminReservationController extends Controller
{
    public function index(AdminHistoriqueReservationDataTable $dataTable)
    {
        return $dataTable->render('admin.reservation.index');
    }
    
    public function showReservationForm()
    {
        $user = Auth::user();
        // $machines = Machine::all(); // Récupère toutes les machines
        $machines = Machine::where('status', 'available')->get();
        $sessionResetTime = Setting::getSetting('reset_time', '00:00');
        $sessionResetTime = Carbon::parse($sessionResetTime);
        $sessionStartTime = Setting::getSetting('session_start_time', '06:00');
        $sessionStartTime = Carbon::parse($sessionStartTime);
        $sessionDuration = (int) Setting::getSetting('session_duration', '120');
        $sessionDuration = Carbon::now()->startOfDay()->addMinutes($sessionDuration)->format('H:i');

        if ($sessionResetTime->eq($sessionStartTime)) {
            $sessionResetTime->addDay();
        }
        // Si l'heure de réinitialisation est inférieure à l'heure de début de session, ajoutez un jour à l'heure de réinitialisation
        if ($sessionResetTime->lt($sessionStartTime)) {
            $sessionResetTime->addDay();
        }
        // Définir la limite de sessions autorisées (à récupérer depuis les paramètres admin si disponible)
        $totalSessionsAllowed = Setting::getSetting('weekly_session_limit', 3);

        // Obtenir le nombre de sessions utilisées par l'utilisateur cette semaine
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $sessionsUsed = Reservation::where('user_id', $user->id)
                ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                ->count();

        // Calculer les sessions restantes
        $weeklySessionLimitRemaining = max(0, $totalSessionsAllowed - $sessionsUsed);

        toastr()->info('Il vous reste ' . $weeklySessionLimitRemaining . ' sessions cette semaine.');

        return view('admin.reservation.create', compact('machines', 'weeklySessionLimitRemaining', 'sessionStartTime', 'sessionResetTime', 'sessionDuration'));
    }

    public function reserve(Request $request)
    {
        // Validations côté contrôleur en cas d'erreurs (même si elles sont couvertes par les middlewares)
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ]);

        $userId = $request->user()->id;
        $machineId = $request->input('machine_id');
        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));

        // Calcul du nombre de réservations restantes
        $weeklyLimit = Setting::getSetting('weekly_session_limit', 3);
        $reservationsCount = Reservation::where('user_id', $userId)
                                        ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                                        ->count();
        $weeklySessionLimitRemaining = max($weeklyLimit - $reservationsCount, 0);

        // Création de la réservation après validation
        $reservation = Reservation::create([
            'user_id' => $userId,
            'machine_id' => $machineId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'weekly_session_limit_remaining' => $weeklySessionLimitRemaining - 1
        ]);

        // Envoyer la notification par email
        $user = Auth::user();
        $user->notify(new ReservationNotification($reservation));
        toastr()->success('Réservation confirmée pour ' . $startTime->format('H:i') . ' à ' . $endTime->format('H:i'));
        return back();
    }

    public function editReservation($id)
    {
        $user = Auth::user();
        $reservation = Reservation::findOrFail($id);

        // Vérifier si l'heure actuelle dépasse l'heure de début de réservation
        if (Carbon::now()->gt($reservation->start_time)) {
            toastr()->error('Impossible de modifier, la session est expirée.');
            return redirect()->route('admin.reservation.index');
        }

        // Vérifier si la machine est disponible
        $machine = Machine::findOrFail($reservation->machine_id);
        if ($machine->status !== 'available') {
            toastr()->error('Impossible de modifier, la machine n\'est pas disponible.');
            return redirect()->route('admin.reservation.index');
        }

        // Obtenir les machines disponibles
        $machines = Machine::where('status', 'available')->get();

        // Obtenir les heures de session à partir des paramètres
        $sessionResetTime = Setting::getSetting('reset_time', '00:00');
        $sessionResetTime = Carbon::parse($sessionResetTime);
        $sessionStartTime = Setting::getSetting('session_start_time', '06:00');
        $sessionStartTime = Carbon::parse($sessionStartTime);

        if ($sessionResetTime->lt($sessionStartTime)) {
            $sessionResetTime->addDay();
        }

        // Limite de sessions hebdomadaires
        $totalSessionsAllowed = Setting::getSetting('weekly_session_limit', 3);
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $sessionsUsed = Reservation::where('user_id', $user->id)
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->count();

        $weeklySessionLimitRemaining = max(0, $totalSessionsAllowed - $sessionsUsed);

        return view('admin.reservation.edit', compact(
            'reservation', 'machines', 'weeklySessionLimitRemaining', 'sessionStartTime', 'sessionResetTime'
        ));
    }


    public function updateReservation(Request $request, $id)
    {
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'start_time' => 'required|date|after_or_equal:' . Carbon::now(),
            'end_time' => 'required|date|after:start_time',
        ]);

        $reservation = Reservation::findOrFail($id);

        // Vérifier si l'heure actuelle dépasse l'heure de début de réservation
        if (Carbon::now()->gt($reservation->start_time)) {
            toastr()->error('Impossible de modifier, la session est expirée.');
            return redirect()->route('admin.reservation.index');
        }

        // Vérifier si la machine est disponible
        $machine = Machine::findOrFail($request->machine_id);
        if ($machine->status !== 'available') {
            toastr()->error('Impossible de modifier, la machine n\'est pas disponible.');
            return redirect()->route('admin.reservation.index');
        }

        $reservation->update([
            'machine_id' => $request->machine_id,
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->end_time),
        ]);

        toastr()->success('Réservation mise à jour avec succès.');
        return redirect()->route('admin.reservation.index');
    }


    public function showReservationDetails($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('admin.reservation.show-reservation-content', compact('reservation'));
    }

    
    public function cancelReservation(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        // Vérifier si l'heure actuelle dépasse l'heure de début de réservation
        if (Carbon::now()->gt($reservation->start_time)) {
            return response()->json(['status' => 'error', 'message' => 'Impossible de supprimer, la session est expirée.']);
        }

        // Vérifier si la machine est disponible
        $machine = Machine::findOrFail($reservation->machine_id);
        if ($machine->status !== 'available') {
            return response()->json(['status' => 'error', 'message' => 'Impossible de supprimer, la machine n\'est pas disponible.']);
        }

        $reservation->delete();

        return response()->json(['status' => 'success', 'message' => 'Réservation supprimée avec succès.!']);
    }


}
