<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;  // add this
use Illuminate\Http\Request;

class StaffController extends Controller
{
   // SINGLE ADMIN PAGE
    public function index(){
        
        $search_user = request('search_user');
        $search_course = request('search_course');

        $users = User::with('staff')
            ->when($search_user, function($query) use ($search_user) {
                $query->where('name', 'like', "%{$search_user}%")
                    ->orWhere('email', 'like', "%{$search_user}%");
            })
            ->get();

        $staff = Staff::with('user')->get();

        $courses = Course::with('staff.user')
            ->withCount('enrollments')
            ->withSum('enrollments', 'amount_paid')
            ->when($search_course, function($query) use ($search_course) {
                $query->where('course_name', 'like', "%{$search_course}%");
            })
            ->get();

        $editcourses = request('edit') ? Course::find(request('edit')) : null;

        // add this
        $pendingEnrollments = Enrollment::with(['user', 'course'])
                                        ->where('status', 'pending')
                                        ->latest()
                                        ->get();

        return view('admin.index', compact('users', 'staff', 'courses', 'editcourses', 'pendingEnrollments')); // add pendingEnrollments
    }

    // PROMOTE
    public function promote(User $user)
    {
        Staff::firstOrCreate([
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'User promoted to staff');
    }

    // DEMOTE
    public function demote(User $user)
    {
        Staff::where('user_id', $user->id)->delete();

        return back()->with('success', 'User demoted from staff');
    }

    // DELETE
    public function destroyUser(User $user)
    {
        if ($user->email === 'admin@1234') {
            return back()->with('error', 'Cannot delete the admin account.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}