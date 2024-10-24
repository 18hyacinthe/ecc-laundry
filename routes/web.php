<?php
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\MachineController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

/** User Routes */
Route::prefix('user')->as('user.')->middleware(['auth', 'role:user'])->group(function () {
    /** User Dashboard Routes */
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    /** User Profile Routes */
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [UserProfileController::class, 'updateProfile'])->name('profile.update');
});

/** Admin Routes */
Route::prefix('admin')->as('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    /** Admin Dashboard Routes */
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /** Admin Profile Routes */
    Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/update/password', [AdminProfileController::class, 'updatePassword'])->name('profile.update.password');


    /** Machine Routes */
    Route::resource('machines', MachineController::class);
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
