<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class StaffPanelController extends Controller
{
    public function index()
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            return redirect()->route('dashboard')->with('error', 'You are not a staff member.');
        }

        $courses = Course::where('staff_id', $staff->id)
            ->withCount('enrollments')
            ->withSum('enrollments', 'amount_paid')
            ->with(['enrollments.user', 'contents'])
            ->get();

        $totalEnrolled = $courses->sum('enrollments_count');
        $totalEarned = $courses->sum('enrollments_sum_amount_paid');

        return view('staff.index', compact('courses', 'totalEnrolled', 'totalEarned'));
    }

    public function removeEnrollment(Enrollment $enrollment)
    {
        $staff = auth()->user()->staff;

        if (!$staff || $enrollment->course->staff_id !== $staff->id) {
            abort(403);
        }

        $enrollment->delete();

        return back()->with('success', 'Enrollment removed.');
    }

    public function profile()
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            return redirect()->route('dashboard')->with('error', 'You are not a staff member.');
        }

        return view('staff.profile');
    }

    public function updateProfile(Request $request)
    {
        $staff = auth()->user()->staff;

        if (!$staff) {
            return redirect()->route('dashboard')->with('error', 'You are not a staff member.');
        }

        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($data);

        return redirect()->route('staff.profile')->with('status', 'profile-updated');
    }


}
