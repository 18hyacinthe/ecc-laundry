<?php
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminMachineController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AdminCalendarReservationController;
use App\Http\Controllers\Admin\AdminReclamationController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserReservationController;
use App\Http\Controllers\Frontend\MachineOverviewController;
use App\Http\Controllers\Frontend\UserCalendarReservationController;
use App\Http\Controllers\Frontend\UserReclamationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

/** Language Routes */
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

/** User Routes */
Route::prefix('user')->as('user.')->middleware(['auth', 'verified', 'role:user'])->group(function () {
    /** User Dashboard Routes */
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    /** User Profile Routes */
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::post('profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password/update', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');

    /** Reservation Routes */
    Route::get('/reservation', [UserReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/create', [UserReservationController::class, 'showReservationForm'])
        ->middleware('check.user.status')
        ->name('showReservationForm');
    Route::get('/reservations/{hashedId}', [UserReservationController::class, 'showReservationDetails'])->name('reservations.details');
    Route::delete('/reservations/{hashedId}', [UserReservationController::class, 'cancelReservation'])->name('reservations.destroy');
    Route::get('/reservation/{hashedId}/edit', [UserReservationController::class, 'editReservation'])->name('reservation.edit');
    Route::put('/reservation/{hashedId}/update', [UserReservationController::class, 'updateReservation'])->name('reservation.update');

    /** Reservation Routes avec middlewares spécifiques */
    Route::post('/reserve', [UserReservationController::class, 'reserve'])
       ->middleware(['checkWeeklyLimit', 'checkSlotAvailability', 'checkSessionDuration'])
       ->name('reserve');

    /** Machine Routes */
    Route::get('/machines/status', [MachineOverviewController::class, 'index'])->name('machines.index');
    Route::get('/machines/{hashedId}/details', [MachineOverviewController::class, 'showMachineDetails'])->name('machines.details');

    /** Calendar Routes */
    Route::get('reservation/calendar', [UserCalendarReservationController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/machines/{hashedId}/details', [UserCalendarReservationController::class, 'getMachineDetails'])->name('calendar.machine.details');

    /** Reclamation Routes */
    Route::get('reclamations', [UserReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('/reclamations/create', [UserReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('/reclamations/store', [UserReclamationController::class, 'store'])->name('reclamations.store');
    Route::get('/reclamations/{hashedId}', [UserReclamationController::class, 'show'])->name('reclamations.show');
});

/** Admin Routes */
Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    /** Admin Dashboard Routes */
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /** Admin Profile Routes */
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/update/password', [AdminProfileController::class, 'updatePassword'])->name('profile.update.password');

    /** Machine Routes */
    Route::get('/machines', [AdminMachineController::class, 'index'])->name('machines.index');
    Route::get('/machines/create', [AdminMachineController::class, 'create'])->name('machines.create');
    Route::post('/machines/store', [AdminMachineController::class, 'store'])->name('machines.store');
    Route::get('/machines/{hashedId}/edit', [AdminMachineController::class, 'edit'])->name('machines.edit');
    Route::put('/machines/{hashedId}/update', [AdminMachineController::class, 'update'])->name('machines.update');
    Route::delete('/machines/{hashedId}', [AdminMachineController::class, 'destroy'])->name('machines.destroy');

    /** User Routes */
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{hashedId}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{hashedId}/update', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{hashedId}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    /** Reservation Routes */
    Route::get('/reservation', [AdminReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/create', [AdminReservationController::class, 'showReservationForm'])
        ->middleware('check.user.status')
        ->name('showReservationForm');
    Route::get('/reservations/{hashedId}', [AdminReservationController::class, 'showReservationDetails'])->name('reservations.details');
    Route::delete('/reservations/{hashedId}', [AdminReservationController::class, 'cancelReservation'])->name('reservations.destroy');
    Route::get('/reservation/{hashedId}/edit', [AdminReservationController::class, 'editReservation'])->name('reservation.edit');
    Route::put('/reservation/{hashedId}/update', [AdminReservationController::class, 'updateReservation'])->name('reservation.update');

    /** Reservation Routes avec middlewares spécifiques */
    Route::post('/reserve', [AdminReservationController::class, 'reserve'])
       ->middleware(['checkSlotAvailability', 'checkSessionDuration'])
       ->name('reserve');

    /** Calendar Routes */
    Route::get('/reservation/calendrier', [AdminCalendarReservationController::class, 'index'])->name('calendar.reservation');
    Route::get('/calendar/machines/{hashedId}/details', [AdminCalendarReservationController::class, 'getMachineDetails'])->name('calendar.machine.details');

    /** Reclamation Routes */
    Route::get('reclamations', [AdminReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('/reclamations/{hashedId}', [AdminReclamationController::class, 'show'])->name('reclamations.show');

    /** Settings Routes */
    // Reservation settings
    Route::get('/settings/reservations', [AdminSettingsController::class, 'showReservationsSettings'])->name('settings.reservations');
    Route::post('/settings/reservations', [AdminSettingsController::class, 'updateReservationsSettings']);
    Route::post('/settings/reset-system', [AdminSettingsController::class, 'updateResetSystem'])->name('settings.reset-system.update');
    Route::post('/settings/reset-system/manual', [AdminSettingsController::class, 'manualReset'])->name('settings.reset-system.reset');

    // Domain restriction settings
    Route::get('/settings/domain-restriction', [AdminSettingsController::class, 'showDomainCheck'])->name('settings.DomainRestriction');
    Route::post('/settings/domain-restriction/update', [AdminSettingsController::class, 'updateDomainCheck'])->name('settings.updateDomainCheck');
});


require __DIR__.'/auth.php';
