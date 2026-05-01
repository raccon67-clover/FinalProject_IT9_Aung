<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;

class CourseContentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $staff = auth()->user()->staff;

        if (!$staff || $course->staff_id !== $staff->id) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $course->contents()->create([
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return back()->with('success', 'Teaching content added.');
    }

    public function destroy(CourseContent $content)
    {
        $staff = auth()->user()->staff;

        if (!$staff || $content->course->staff_id !== $staff->id) {
            abort(403);
        }

        $content->delete();

        return back()->with('success', 'Teaching content deleted.');
    }
}
