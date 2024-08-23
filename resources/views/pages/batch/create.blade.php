@extends('layouts.app', ['activePage' => 'batch', 'titlePage' => 'Create Batch'])
@push('custom_style')


@endpush
@section('content')
    <section id="content-wrapper bg-white p-5" style="margin: 50px">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h2 class="content-title">Add New Batch</h2>
            </div>
        </div>

        <div class="row">
           <div class="card p-5" style="background-color:#ececec">
            <form method="post" action="{{ route('batches.store') }}" autocomplete="off">
                @csrf

                <div class="row mb-3">
                  <div class="form-group col-md-6">
                    <label for="">Label</label>
                    <input type="text" class="form-control" id="" placeholder="Label" name="label">
                    @error('label')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                      <label for="">Intake Start Date</label>
                      <input type="date" class="form-control" id="" placeholder="Start Date" name="intake_start_date">
                      @error('intake_start_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Intake End Date</label>
                        <input type="date" class="form-control" id="" placeholder="End Date" name="intake_end_date">
                        @error('intake_end_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <button type="submit" class="btn btn-primary" style="float:right">ADD BATCH</button>
            </form>

           </div>
        </div>
    </section>
@endsection

@push('custom_scripts')

@endpush
