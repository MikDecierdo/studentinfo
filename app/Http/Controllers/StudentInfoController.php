<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentInfo;
class StudentInfoController extends Controller
{
    /** Display a list of students and the form. */
    public function index()
    {
        $students = StudentInfo::orderBy('id', 'desc')->get();
        return view('form', compact('students'));
    }

    /** Redirect create to index (form is on index). */
    public function create()
    {
        return redirect()->route('students.index');
    }

    /** Store a new student and uploaded image. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', strtolower($file->getClientOriginalName()));
            // save to public/images
            $file->move(public_path('images'), $filename);
        }

        StudentInfo::create([
            'name' => $validated['name'],
            'birthdate' => $validated['birthdate'],
            'email' => $validated['email'],
            'image' => $filename,
        ]);

        return redirect()->route('students.index')->with('success', 'Student information saved.');
    }
}
