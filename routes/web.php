<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FYPCoorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainMenuController;
use App\Http\Controllers\ManageTopicController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TimeFrameController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Home / dashboard redirect (role-based)
Route::get('/home', [LoginController::class, 'index'])->name('home')->middleware('auth');

// Password management (student & lecturer)
Route::get('/changePassword',  [LoginController::class, 'changePassword'])->name('changePassword')->middleware('auth');
Route::post('/newPassword',    [LoginController::class, 'newPassword'])->name('newPassword')->middleware('auth');

// ─── FYP COORDINATOR ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:fypcoordinator'])->group(function () {
    Route::get('/fypstudentList',   [MainMenuController::class, 'fypstudentList'])->name('fypstudentList');
    Route::get('/fyplecturerList',  [MainMenuController::class, 'fyplecturerList'])->name('fyplecturerList');
    Route::get('/uploadUser',       [MainMenuController::class, 'uploadUser'])->name('uploadUser');
    Route::get('/fypReport',        [MainMenuController::class, 'fypReport'])->name('fypReport');
    Route::post('/generateReport',  [MainMenuController::class, 'generateReport'])->name('generateReport');
    Route::get('/manageQuota',      [MainMenuController::class, 'manageQuota'])->name('manageQuota');
    Route::post('/generateQuota',   [FYPCoorController::class,  'generateQuota'])->name('generateQuota');
    Route::get('/updateQuota',      [FYPCoorController::class,  'updateQuota'])->name('updateQuota');
    Route::post('/updateQuotaList', [FYPCoorController::class,  'updateQuotaList'])->name('updateQuotaList');
    Route::get('/userList',         [MainMenuController::class, 'userList'])->name('userList');

    // Time Frame (TimeFrameController)
    Route::get('/manageTimeFrame',        [TimeFrameController::class, 'manageTimeFrame'])->name('manageTimeFrame');
    Route::post('/saveTimeFrame',         [TimeFrameController::class, 'saveTimeFrame'])->name('saveTimeFrame');
    Route::post('/setActiveTimeFrame/{id}', [TimeFrameController::class, 'setActive'])->name('setActiveTimeFrame');
    Route::post('/deleteTimeFrame/{id}',  [TimeFrameController::class, 'deleteTimeFrame'])->name('deleteTimeFrame');

    // CSV upload
    Route::post('/upload_user',           [UploadController::class, 'upload_user'])->name('upload_user');
    Route::get('/download-user-template', [UploadController::class, 'downloadUserTemplate'])->name('downloadUserTemplate');
});

// ─── LECTURER ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:lecturer'])->group(function () {
    // Profile
    Route::get('/viewProfile',                [MainMenuController::class, 'viewProfile'])->name('viewProfile');
    Route::post('/uploadPicture/{lecturerID}', [MainMenuController::class, 'uploadPicture'])->name('uploadPicture');
    Route::post('/uploadTimetable/{lecturerID}', [MainMenuController::class, 'uploadTimetable'])->name('uploadTimetable');

    // Appointments
    Route::get('/responseAppointment',  [AppointmentController::class, 'responseAppointment'])->name('responseAppointment');
    Route::post('/approval/{id}',       [AppointmentController::class, 'approval'])->name('approval');

    // Topic / Proposal management
    Route::post('/postTopic',           [ProposalController::class, 'postTopic'])->name('postTopic');
    Route::get('/editTopic/{topicID}',  [ProposalController::class, 'editTopic'])->name('editTopic');
    Route::post('/updateTopic/{topicID}', [ProposalController::class, 'updateTopic'])->name('updateTopic');
    Route::post('/deleteTopic/{topicID}', [ProposalController::class, 'deleteTopic'])->name('deleteTopic');
    Route::get('/topicApproval',        [ProposalController::class, 'topicApproval'])->name('topicApproval');
    Route::get('/review/{id}',          [ProposalController::class, 'review'])->name('review');
    Route::post('/updateApplication/{id}', [ProposalController::class, 'updateApplication'])->name('updateApplication');
});

// ─── STUDENT ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:student'])->group(function () {
    // Lecturer browsing
    Route::get('/listOfLecturer',               [ProposalController::class, 'listOfLecturer'])->name('listOfLecturer');
    Route::get('/lecturerProfile/{lecturerID}', [ProposalController::class, 'lecturerProfile'])->name('lecturerProfile');

    // Topics
    Route::get('/applyTopic/{lecturerID}',  [ProposalController::class, 'applyTopic'])->name('applyTopic');
    Route::post('/apply',                   [ProposalController::class, 'apply'])->name('apply');
    Route::get('/topicRequest',             [ProposalController::class, 'topicRequest'])->name('topicRequest');
    Route::post('/cancelRequest/{id}',      [ProposalController::class, 'cancelRequest'])->name('cancelRequest');

    // Appointments
    Route::get('/applyAppointment/{lecturerID}', [AppointmentController::class, 'applyAppointment'])->name('applyAppointment');
    Route::post('/applyForm',                    [AppointmentController::class, 'applyForm'])->name('applyForm');
    Route::get('/appointmentRequest',            [AppointmentController::class, 'appointmentRequest'])->name('appointmentRequest');
    Route::post('/cancelAppointment/{id}',       [AppointmentController::class, 'cancelAppointment'])->name('cancelAppointment');
});

// ─── NOTIFICATIONS (all authenticated users) ────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/notifications',           [NotificationsController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationsController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationsController::class, 'markAllRead'])->name('notifications.readAll');
    Route::get('/notifications/count',     [NotificationsController::class, 'unreadCount'])->name('notifications.count');
});

// ─── JETSTREAM / SANCTUM dashboard ──────────────────────────────────────────
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');
});
