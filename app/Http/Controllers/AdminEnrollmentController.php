<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminEnrollmentController extends Controller
{
    public function approve(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'approved']);
        return back()->with('success', 'Enrollment approved.');
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'rejected']);
        return back()->with('success', 'Enrollment rejected.');
    }
}