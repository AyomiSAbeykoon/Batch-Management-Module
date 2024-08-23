
@extends('layouts.app', ['activePage' => 'students', 'titlePage' => 'Students'])
@push('custom_style')
@endpush
@section('content')
    <section id="content-wrapper bg-white p-5" style="margin: 50px">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h2 class="content-title">Student Log Data</h2>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                    <tr class="">
                        <th class="text-center"><span class="blue_text">Event Type</span></th>
                        <th class="text-center"><span class="blue_text">Field Modified</span>
                        </th>
                        <th class="text-center"><span class="blue_text">Previous Value</th>
                        <th class="text-center"><span class="blue_text">Changed Value</th>
                        <th class="text-center"><span class="blue_text">Changed By</th>
                        <th class="text-center"><span class="blue_text">Changed On</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $diff1 = $studentData ? $studentData->audits()->with('user')->get()->sortByDesc('created_at') : collect();
                    @endphp


                    @foreach ($diff1 as $diff)
                       <td>{{$diff->event}}</td>
                       <td>{{$diff->event}}</td>
                       <td>
                        @foreach ($diff['old_values'] as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }} <br>
                            @endforeach</td>

                            <td>
                                @foreach ($diff['new_values'] as $key => $value)
                                    {{ ucfirst($key) }}: {{ $value }} <br>
                                    @endforeach</td>
                       <td>{{$diff->user->name}}</td>
                       <td>{{$diff->created_at}}</td>
                    @endforeach

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
