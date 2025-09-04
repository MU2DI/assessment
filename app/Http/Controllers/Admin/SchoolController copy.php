<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller 
{
    public function __construct()
    {
        // Now these will work
       $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $schools = School::orderBy('school_name')->get(); // Make sure to fetch schools
        return view('admin.schools.index', compact('schools')); // Pass to view
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:100',
            'address' => 'required|string',
            'contact_phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100'
        ]);

        // Generate center code (DM001 format)
        $lastSchool = School::orderBy('center_code', 'desc')->first();
        $newCode = $lastSchool ? 'DM' . str_pad((int) substr($lastSchool->center_code, 2) + 1, 3, '0', STR_PAD_LEFT) : 'DM001';

        School::create([
            'center_code' => $newCode,
            'school_name' => $request->school_name,
            'address' => $request->address,
            'contact_phone' => $request->contact_phone,
            'email' => $request->email
        ]);

        return redirect()->route('admin.schools.index')
            ->with('success', 'School created successfully');
    }

    // Implement other methods (show, edit, update, destroy) similarly
}
