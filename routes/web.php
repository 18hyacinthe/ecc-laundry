<?php
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminMachineController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AdminCalendarReservationController;
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
    Route::get('/reservation/create', [UserReservationController::class, 'showReservationForm'])->name('showReservationForm');
    
    /** Reservation Routes avec middlewares spécifiques */
    Route::post('/reserve', [UserReservationController::class, 'reserve'])
       ->middleware(['checkWeeklyLimit', 'checkSlotAvailability', 'checkSessionDuration'])
       ->name('reserve');

    /** Machine Routes */
    Route::get('/machines/status', [MachineOverviewController::class, 'index'])->name('machines.index');

    /** Calendar Routes */
    Route::get('reservation/calendar', [UserCalendarReservationController::class, 'index'])->name('calendar.index');

    /** Reclamation Routes */
    Route::get('reclamations', [UserReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('/reclamations/create', [UserReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('/reclamations/store', [UserReclamationController::class, 'store'])->name('reclamations.store');
    Route::get('/reclamations/{id}', [UserReclamationController::class, 'show'])->name('reclamations.show');
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
    Route::resource('machines', AdminMachineController::class);

    /** User Routes */
    Route::resource('users', AdminUserController::class);

    /** Reservation Routes */
    Route::post('/reserve', [AdminReservationController::class, 'reserve'])->name('reserve');
    Route::get('/reservation/calendrier', [AdminCalendarReservationController::class, 'index'])->name('calendar.reservation');

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
