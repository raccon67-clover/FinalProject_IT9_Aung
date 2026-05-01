<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\CourseContent;
use Illuminate\Http\Request;

class MemberLearningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $enrollments = Enrollment::with([
                'course.staff.user',
                'course.contents.completedByUsers',
            ])
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->get();

        return view('member.learnings', compact('enrollments', 'search'));
    }

    public function complete(CourseContent $content)
    {
        $isEnrolled = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $content->course_id)
            ->where('status', 'approved')
            ->exists();

        if (!$isEnrolled) {
            abort(403);
        }

        $content->completedByUsers()->syncWithoutDetaching([auth()->id()]);

        return back()->with('success', 'Lesson marked as complete.');
    }
}
