<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    return redirect('/DoListify/Login');
});

// Guest routes (only accessible when NOT logged in)
Route::middleware(['guest'])->group(function () {
    Route::get('/DoListify/Login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/DoListify/Login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/DoListify/Register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/DoListify/Register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/DoListify/Forgot-Password', [AuthController::class, 'showForgetPassword'])->name('forgot.password');
    Route::post('/DoListify/Forgot-Password', [AuthController::class, 'forgotPassword'])->name('forgot.password.post');
});

// Auth routes (require login)
Route::middleware(['auth'])->group(function () {

    Route::get('/DoListify/Profile', [SettingsController::class, 'showProfile'])->name('profile');
    Route::post('/DoListify/Profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile/remove-avatar', [SettingsController::class, 'removeAvatar'])->name('profile.removeAvatar');

    // Page View Routes
    Route::get('/DoListify/Dashboard', [ProjectController::class, 'getProjectStats'])->name('dashboard');
    Route::get('/DoListify/Add/Task/', [ProjectController::class, 'showAddTask'])->name('addTask');
    Route::view('/DoListify/Add/Project', 'pages.AddProject')->name('addProject');
    Route::view('/DoListify/Team', 'pages.Team')->name('team');
    Route::view('/DoListify/Calendar', 'pages.Calendar')->name('calendar');
    Route::view('/DoListify/Leaderboard', 'pages.Leaderboard')->name('leaderboard');
    Route::view('/DoListify/Settings', 'pages.Settings')->name('settings');

    // Project Related Routes
    Route::get('/DoListify/Task/To Do',[ProjectController::class, 'projectView'] )->name('projects');
    Route::post('/DoListify/Add-Task/personal', [ProjectController::class, 'store'])->name('addTask.post');
    Route::post('/DoListify/Add-Project/team', [ProjectController::class, 'storeTeamProject'])->name('projects.storeTeam');
    Route::get('/DoListify/Projects/filter', [ProjectController::class, 'filter'])->name('projects.filter');
    Route::get('/DoListify/search-projects', [ProjectController::class, 'searchProjects'])->name('search.projects');

    // Task Related Routes
    Route::match(['get', 'post'], '/DoListify/Task/{projectId}', [TaskController::class, 'taskview'])->name('task');
    Route::get('/DoListify/Task/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/task/{projectId}/attachment', [TaskController::class, 'storeAttachment'])->name('task.uploadAttachment');

    Route::patch('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.getUnreadCount');

    // User Management Routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/api/validate-user', [ProjectController::class, 'validateUser'])->name('validate.user');
    Route::get('/api/search-users', [ProjectController::class, 'searchUsers'])->name('search.users');

    // Settings Routes
    Route::post('/settings/update-name', [SettingsController::class, 'updateName'])->name('name.update');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('password.update');
});

// Registration verification routes
Route::middleware(['guest', 'registration.session'])->group(function () {
    Route::get('/DoListify/Verify-Email', [AuthController::class, 'showeVerify'])->name('auth.eVerifyget');
    Route::post('/DoListify/Verify-Email', [AuthController::class, 'verify'])->name('auth.eVerify');
    Route::get('/DoListify/Successful-Registration', [AuthController::class, 'showVerifySuccess'])->name('auth.registerSuccess');
});

// Login verification routes
Route::middleware(['guest', 'login.session'])->group(function () {
    Route::get('/DoListify/Verify-its-you', [AuthController::class, 'showVerifyLogin'])->name('auth.verifyLogin');
    Route::post('/DoListify/Verify-its-you', [AuthController::class, 'verifyLogin'])->name('auth.verifyLoginUser');
});

// Password reset routes
Route::middleware(['guest', 'password.reset'])->group(function () {
    Route::get('/DoListify/Reset-Password/{token}', [AuthController::class, 'showResetPassword'])->name('reset.password');
    Route::post('/DoListify/Reset-Password', [AuthController::class, 'resetPassword'])->name('reset.password.post');
    Route::get('/DoListify/Successful-Reset-Password', [AuthController::class, 'showResetSuccess'])->name('auth.resetSuccess');
});

// Verification resend routes
Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('resend.verification');
Route::post('/resend-verification-login', [AuthController::class, 'resendVerificationLogin'])->name('resend.verificationLogin');