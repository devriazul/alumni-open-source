<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Apply filters
        if ($request->filled('session')) {
            $query->where('session', $request->session);
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        $students = $query->paginate(50);
        $sessions = Student::distinct()->pluck('session');
        $departments = Student::distinct()->pluck('department');
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        return view('students.index', compact('students', 'sessions', 'departments', 'bloodGroups'));
    }

    public function create()
    {
        return view('students.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'blood_group' => 'nullable|string|max:5',
            'session' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'employment_status' => 'nullable|in:employed,unemployed,student',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = Storage::url($path);
        }

        Student::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return response()->json($student);
    }

    public function edit(Student $student)
    {
        return view('students.form', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'blood_group' => 'nullable|string|max:5',
            'session' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'gender' => 'required|in:male,female,other',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'employment_status' => 'nullable|in:employed,unemployed,student',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::delete(str_replace('/storage', 'public', $student->photo));
            }
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = Storage::url($path);
        }

        $student->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo) {
            Storage::delete(str_replace('/storage', 'public', $student->photo));
        }
        $student->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Student deleted successfully.');
    }
}