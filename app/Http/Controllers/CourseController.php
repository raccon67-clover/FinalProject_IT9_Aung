<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $staff = Staff::with('user')->get();
        $users = User::with('staff')->get();
        $editcourses = null;

        if(request('edit')){
            $editcourses = Course::find(request('edit'));
        }

        return view('admin.index', compact('courses', 'editcourses', 'staff', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'slot' => 'required|integer|min:0',
            'staff_id' => 'required|integer|exists:staff,id', 
        ]);

        Course::create($validated);

        return redirect()->route('admin.index')->with('success', 'Course added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'slot' => 'required|integer|min:0',
            'staff_id' => 'required|integer|exists:staff,id', 
        ]);

        $course = Course::findOrFail($id);
        $course->update($validated);

        return redirect()->route('admin.index')->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('success', 'Course deleted successfully');
    }
}
