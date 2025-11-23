@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Employee List</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>All Employees</span>
                    <a href="{{ url('employees/create') }}" class="btn btn-primary btn-sm">Add New Employee</a>
                </div>
                <div class="card-body">
                    @if ($employees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr id="employee-row-{{ $employee->id }}">
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->fullname ?? '-' }}</td>
                                            <td>{{ $employee->status ?? '-' }}</td>
                                            <td>
                                                <a href="{{ url('employees/' . $employee->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $employee->id }}">
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
                            No employees found.
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
                    Are you sure you want to delete this employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let employeeIdToDelete = null;

        console.log('Delete script loaded'); // <-- Tambahkan ini

        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            employeeIdToDelete = button.getAttribute('data-id');
            console.log('Modal shown, employeeIdToDelete:', employeeIdToDelete); // <-- Tambahkan ini
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            console.log('Delete button clicked, id:', employeeIdToDelete); // <-- log ini
            if (!employeeIdToDelete) {
                alert('ID not found!');
                return;
            }

            fetch("{{ url('employees') }}/" + employeeIdToDelete, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest', // <-- Tambahkan ini
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Fetch response:', response);
                    if (response.ok) {
                        document.getElementById('employee-row-' + employeeIdToDelete).remove();
                        var modal = bootstrap.Modal.getInstance(deleteModal);
                        modal.hide();
                    } else {
                        alert('Failed to delete employee.');
                    }
                })
                .catch((e) => {
                    console.log('Fetch error:', e);
                    alert('Failed to delete employee.');
                });
        });
    </script>
@endpush
