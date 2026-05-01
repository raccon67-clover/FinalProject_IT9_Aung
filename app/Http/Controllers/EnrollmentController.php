<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function checkout(Request $request, Course $course)
    {
        $request->validate([
            'type' => 'required|in:monthly,yearly',
        ]);

        $user = auth()->user();

        // Check if already enrolled or pending
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) {
                $q->where('expires_at', '>', now())
                ->orWhere('status', 'pending');
            })
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have a pending or active enrollment for this course.');
        }

        // Check available slots
        $enrolled = Enrollment::where('course_id', $course->id)
            ->where('status', 'approved')
            ->count();

        if ($enrolled >= $course->slot) {
            return back()->with('error', 'No slots available.');
        }

        // Mock payment — skip PayMongo, go straight to success
        return redirect()->route('enrollments.payment.success', [
            'course' => $course->id,
            'type'   => $request->type,
        ]);
    }
    public function success(Request $request)
    {
        $user     = auth()->user();
        $course   = Course::findOrFail($request->query('course'));
        $type     = $request->query('type', 'monthly');
        $isYearly = $type === 'yearly';

        // Guard against duplicate on refresh
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->route('member.index')
                ->with('success', 'Your enrollment for "' . $course->course_name . '" is already on record.');
        }

        // Re-check slots
        $enrolled = Enrollment::where('course_id', $course->id)
            ->where('status', 'approved')
            ->count();

        if ($enrolled >= $course->slot) {
            return redirect()->route('member.index')
                ->with('error', 'No slots available for this course.');
        }

        $expiresAt = $isYearly
            ? Carbon::now()->addYear()
            : Carbon::now()->addMonth();

        Enrollment::create([
            'user_id'     => $user->id,
            'course_id'   => $course->id,
            'type'        => $type,
            'amount_paid' => $isYearly ? $course->price * 10 : $course->price,
            'expires_at'  => $expiresAt,
            'status'      => 'pending',
        ]);

        return redirect()->route('member.index')
            ->with('success', 'Payment successful! Your enrollment in "' . $course->course_name . '" is pending staff approval.');
    }

    public function destroy(Enrollment $enrollment)
    {
        // Only the owner can cancel
        if (auth()->id() !== $enrollment->user_id) {
            abort(403);
        }

        $enrollment->delete();
        return back()->with('success', 'Enrollment cancelled successfully.');
    }

    public function receipt(Enrollment $enrollment)
    {
        if (auth()->id() !== $enrollment->user_id && !auth()->user()->staff) {
            abort(403);
        }

        $enrollment->load('course.staff.user', 'user');
        return view('receipt', compact('enrollment'));
    }
}