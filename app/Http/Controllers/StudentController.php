<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students=Student::get();

        return view('pages.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = Carbon::today();

        $batches = Batch::where(function ($query) use ($today) {
            $query->where(function ($subQuery) use ($today) {
                $subQuery->where('intake_start_date', '<=', $today)
                        ->where('intake_end_date', '>=', $today);
            })->orWhere(function ($subQuery) use ($today) {
                $subQuery->where('is_extended', 1)
                        ->where('extended_date', '>=', $today);
            });
        })->get();

        return view('pages.students.create',compact('batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|digits_between:10,15',
            'nic' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'batch_id' => 'required|exists:batches,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Student::create($request->all());

        return redirect()->route('students.index')->with('message','Student Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student=Student::find($id);

        $today = Carbon::today();

        $batches = Batch::where(function ($query) use ($today) {
            $query->where(function ($subQuery) use ($today) {
                $subQuery->where('intake_start_date', '<=', $today)
                        ->where('intake_end_date', '>=', $today);
            })->orWhere(function ($subQuery) use ($today) {
                $subQuery->where('is_extended', 1)
                        ->where('extended_date', '>=', $today);
            });
        })->get();

        return view('pages.students.edit',compact('batches','student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|digits_between:10,15',
            'nic' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'batch_id' => 'required|exists:batches,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student=Student::find($id);
        $student->update($request->all());

        return redirect()->route('students.index')->with('message','Students Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['success' => 'Students deleted successfully']);
    }

    public function audit_log($id)
    {

        $studentData = Student::whereId( $id)->first();


        return view('pages.students.audit_log', compact('studentData'));
    }
}
