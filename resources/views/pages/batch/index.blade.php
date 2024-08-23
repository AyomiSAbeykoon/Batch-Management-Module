@extends('layouts.app', ['activePage' => 'batch', 'titlePage' => 'Batches'])
@push('custom_style')
@endpush
@section('content')
    <section id="content-wrapper bg-white p-5" style="margin: 50px">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h2 class="content-title">Batches</h2>
                <a href="{{ route('batches.create') }}" class="btn btn-success" style="height: fit-content;">Add Batch</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Intake Start Date</th>
                        <th scope="col">Intake End Date</th>
                        <th scope="col">Intake Extended Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($batches) > 0)
                        @foreach ($batches as $batch)
                            <tr id="batch-row-{{ $batch->id }}">
                                <td>{{ $batch->label }}</td>
                                <td>{{ $batch->intake_start_date }}</td>
                                <td>{{ $batch->intake_end_date }}</td>
                                <td id="batchDate-{{ $batch->id }}">{{ $batch->extended_date ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-info extend-btn" data-id="{{ $batch->id }}"><i
                                            class="fa fa-calendar"></i> Extend</button>
                                    <button class="btn btn-primary"
                                        onclick="location.href = '{{ route('batches.edit', $batch->id) }}';"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger delete-btn" data-id="{{ $batch->id }}"><i
                                            class="fa fa-trash"></i></button>
                                            <button class="btn btn-warning" onclick="location.href = '{{ url('/batches/audit_log', $batch->id) }}';">Log</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center" style="opacity: .5;font-size:small"><i>--No Data--</i>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>


        </div>
        <div class="modal fade" id="extendModal" tabindex="-1" role="dialog" aria-labelledby="extendModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="extendModalLabel">Extend Date</h5>
                        <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="extendDateForm">
                            <div class="form-group">
                                <label for="newDate">New Date</label>
                                <input type="date" class="form-control" id="newDate" required>
                            </div>
                            <input type="hidden" id="batchId" name="batchId">

                            <div class="row mt-5">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary ">Save Changes</button>

                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var batchId = $(this).data('id');
                var row = $('#batch-row-' + batchId);

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
                            url: '/batches/' + batchId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                row.remove();
                                Swal.fire(
                                    'Deleted!',
                                    'The batch has been deleted.',
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

            $('.extend-btn').on('click', function() {
                var batchId = $(this).data('id');

                $('#extendModal').find('#batchId').val(batchId);

                $('#extendModal').modal('show');
            });

            $('#extendDateForm').on('submit', function(event) {
                event.preventDefault();

                var form = $(this);
                var batchId = form.find('#batchId').val();
                var newDate = form.find('#newDate').val();


                $.ajax({
                    url: '/extend-date',
                    method: 'POST',
                    data: {
                        batchId: batchId,
                        newDate: newDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#extendModal').modal('hide');
                        $('#batchDate-' + batchId).text(newDate);
                        toastr.success('Date extended successfully!');
                    },
                    error: function(xhr) {
                        toastr.error('Date extended failed!');
                    }
                });
            });
        });
    </script>

@endsection
