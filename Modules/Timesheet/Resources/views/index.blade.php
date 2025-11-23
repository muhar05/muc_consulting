@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Timesheet List</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>All Timesheet</span>
                    <a href="{{ route('timesheet.create') }}" class="btn btn-primary btn-sm">Add Timesheet</a>
                </div>
                <div class="card-body">
                    @if ($timesheets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Time Start</th>
                                        <th>Time Finish</th>
                                        <th>Employee</th>
                                        <th>Service Used ID</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timesheets as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->timestart }}</td>
                                            <td>{{ $item->timefinish }}</td>
                                            <td>
                                                {{ $employeeList[$item->employees_id] ?? '-' }}
                                            </td>
                                            <td>{{ $item->serviceused_id }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <a href="{{ route('timesheet.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $item->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No timesheet data found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this timesheet?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let timesheetIdToDelete = null;

            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                timesheetIdToDelete = button.getAttribute('data-id');
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (!timesheetIdToDelete) {
                    alert('ID not found!');
                    return;
                }

                fetch("{{ url('timesheet') }}/" + timesheetIdToDelete, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Hapus baris dari tabel
                            document.querySelector('button[data-id="' + timesheetIdToDelete + '"]').closest('tr')
                                .remove();
                            var modal = bootstrap.Modal.getInstance(deleteModal);
                            modal.hide();
                        } else {
                            alert('Failed to delete timesheet.');
                        }
                    })
                    .catch((e) => {
                        alert('Failed to delete timesheet.');
                    });
            });
        </script>
    @endpush
@endsection
