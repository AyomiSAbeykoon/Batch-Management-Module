@extends('layouts.app', ['activePage' => 'students', 'titlePage' => 'Students'])
@push('custom_style')

@endpush
@section('content')
    <section id="content-wrapper bg-white p-5" style="margin: 50px">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h2 class="content-title">Students</h2>
                <a href="{{route('students.create')}}" class="btn btn-success" style="height: fit-content;">Add Student</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Batch Label</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @if(count($students) >0)
                        @foreach($students as $data)
                            <tr  id="student-row-{{ $data->id }}">
                                <td>{{$data->first_name .' ' .$data->last_name }}</td>
                                <td>{{$data->phone_number}}</td>
                                <td>{{$data->email}}</td>
                                @php
                                    $createdAt = \Carbon\Carbon::parse($data->created_at);
                                    $endDate = \Carbon\Carbon::parse($data->batch->intake_end_date);
                                    $extendedDate = $data->batch->is_extended ? \Carbon\Carbon::parse($data->batch->extended_date) : null;
                                @endphp
                                <td>
                                    @if ($createdAt->greaterThan($endDate) && ($extendedDate ? $createdAt->lessThanOrEqualTo($extendedDate) : false))
                                        {{ $data->batch->label . '_extended' }}
                                    @else
                                        {{ $data->batch->label }}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary"
                                        onclick="location.href = '{{ route('students.edit', $data->id) }}';"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger delete-btn" data-id="{{ $data->id }}"><i
                                            class="fa fa-trash"></i></button>
                                    <button class="btn btn-warning" onclick="location.href = '{{ url('/students/audit_log', $data->id) }}';">Log</button>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center" style="opacity: .5;font-size:small"><i>--No Data--</i></td>
                            </tr>
                        @endif
                </tbody>
              </table>


        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var studentId = $(this).data('id');
                var row = $('#student-row-' + studentId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/students/' + studentId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                row.remove();
                                Swal.fire(
                                    'Deleted!',
                                    'The student has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });


        });
    </script>
@endsection
