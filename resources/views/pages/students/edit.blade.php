@extends('layouts.app', ['activePage' => 'students', 'titlePage' => 'Create Student'])
@push('custom_style')
@endpush
@section('content')
    <section id="content-wrapper bg-white p-5" style="margin: 50px">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h2 class="content-title">Edit Student</h2>
            </div>
        </div>

        <div class="row">
            <div class="card p-5" style="background-color:#ececec">
                <form method="post" action="{{ route('students.update',$student->id) }}" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="form-group col-md-12">
                            <label for="">Batch</label>
                            <select class="form-control" name="batch_id">
                                <option value="" disabled>Select Batch</option>
                                @foreach($batches as $batch)
                                    <option value="{{$batch->id}}" {{ $batch->id == $student->batch_id ? 'selected' : '' }}>{{$batch->label}}</option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="">First Name</label>
                            <input type="text" class="form-control" id="" name="first_name" value="{{$student->first_name}}">
                            @error('first_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control" id="" name="last_name" value="{{$student->last_name}}">
                            @error('last_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="" name="email" value="{{$student->email}}">
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone Number</label>
                            <input type="text" class="form-control" id="" name="phone_number" value="{{$student->phone_number}}">
                            @error('phone_number')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="">NIC</label>
                            <input type="text" class="form-control" id="" name="nic" value="{{$student->nic}}">
                            @error('nic')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Gender</label>
                            <select class="form-control" name="gender">
                                <option value="" disabled>Select Gender</option>
                                <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="">Date of Birth</label>
                            <input type="date" class="form-control" id="" name="dob" value="{{$student->dob}}">
                            @error('dob')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Address</label>
                            <input type="text" class="form-control" id="" name="address" value="{{$student->address}}">
                            @error('address')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary" style="float:right">EDIT STUDENT</button>
                </form>

            </div>
        </div>
    </section>
@endsection
