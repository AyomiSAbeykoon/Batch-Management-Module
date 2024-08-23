<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches=Batch::get();

        return view('pages.batch.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.batch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255|unique:batches,label',
            'intake_start_date' => 'required|date',
            'intake_end_date' => 'required|date|after_or_equal:intake_start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Batch::create($request->all());

        return redirect()->route('batches.index')->with('message','Batch Added Successfully');
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
        $batch=Batch::find($id);
        return view('pages.batch.edit',compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'intake_start_date' => 'required|date',
            'intake_end_date' => 'required|date|after_or_equal:intake_start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $batch=Batch::find($id);
        $batch->update($request->all());

        return redirect()->route('batches.index')->with('message','Batch Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();

        return response()->json(['success' => 'Batch deleted successfully']);
    }

    public function extendDate(Request $request)
    {


        $batch=Batch::whereId($request->batchId)->first();
        $batch->update([
            'is_extended' => 1,
            'extended_date' => $request->newDate,
        ]);

        return response()->json(['success' => 'Batch extended successfully']);

    }

    public function audit_log($id)
    {

        $batchData = Batch::whereId( $id)->first();


        return view('pages.batch.audit_log', compact('batchData'));
    }
}
