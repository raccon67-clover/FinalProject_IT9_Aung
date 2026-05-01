<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminEnrollmentController;
use App\Http\Controllers\StaffPanelController;
use App\Http\Controllers\MemberLearningController;
use App\Http\Controllers\CourseContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $courses = \App\Models\Course::with('staff.user')->get();
    return view('welcome', compact('courses'));
});

Route::get('/dashboard', function () {
    if (Auth::user()->email === 'admin@1234') {
        return redirect()->route('admin.index');
    }

    if (Auth::user()->staff) {
        return redirect()->route('staff.panel');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Member area routes
Route::get('/member', function () {
    $courses = \App\Models\Course::with('staff.user', 'enrollments')
        ->withCount('enrollments')
        ->get();

    auth()->user()->load('enrollments');

    return view('member.index', compact('courses'));
})->middleware(['auth', 'verified'])->name('member.index');

Route::get('/member/learnings', [MemberLearningController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('member.learnings');

// Admin area routes
Route::get('/admin', [StaffController::class, 'index'])->name('admin.index');
Route::post('/admin/promote/{user}', [StaffController::class, 'promote'])->name('staff.promote');
Route::delete('/admin/demote/{user}', [StaffController::class, 'demote'])->name('staff.demote');
Route::delete('/admin/users/{user}', [StaffController::class, 'destroyUser'])->name('admin.users.destroy');

// Course management
Route::post('/courses/store', [CourseController::class, 'store'])->name('courses.store');
Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
Route::put('/courses/{id}', [CourseController::class, 'update'])->name('courses.update');

// Enrollments
Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])
    ->name('enrollments.store')
    ->middleware('auth');

Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])
    ->name('enrollments.destroy')
    ->middleware('auth');

Route::post('/courses/{course}/checkout', [EnrollmentController::class, 'checkout'])
    ->name('enrollments.checkout')
    ->middleware('auth');

Route::get('/enrollments/payment/success', [EnrollmentController::class, 'success'])
    ->name('enrollments.payment.success')
    ->middleware('auth');

Route::post('/enrollments/{enrollment}/approve', [AdminEnrollmentController::class, 'approve'])
    ->name('enrollments.approve');

Route::post('/enrollments/{enrollment}/reject', [AdminEnrollmentController::class, 'reject'])
    ->name('enrollments.reject');

// Staff routes
Route::middleware(['auth'])->group(function () {
    Route::get('/staff', [StaffPanelController::class, 'index'])->name('staff.panel');

    Route::get('/staff/profile', [StaffPanelController::class, 'profile'])
        ->name('staff.profile');

    Route::patch('/staff/profile', [StaffPanelController::class, 'updateProfile'])
        ->name('staff.profile.update');

    Route::delete('/staff/enrollments/{enrollment}', [StaffPanelController::class, 'removeEnrollment'])
        ->name('staff.enrollments.destroy');

    Route::post('/staff/courses/{course}/contents', [CourseContentController::class, 'store'])
        ->name('staff.course-contents.store');

    Route::delete('/staff/course-contents/{content}', [CourseContentController::class, 'destroy'])
        ->name('staff.course-contents.destroy');
});

// Receipt
Route::get('/enrollments/{enrollment}/receipt', [EnrollmentController::class, 'receipt'])
    ->name('enrollment.receipt')
    ->middleware('auth');


//Course Content
Route::post('/member/learnings/content/{content}/complete', [MemberLearningController::class, 'complete'])
    ->middleware(['auth', 'verified'])
    ->name('member.learnings.complete');


require __DIR__.'/auth.php';
