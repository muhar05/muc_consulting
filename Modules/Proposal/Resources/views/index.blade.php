@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2>Proposal List</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <span>All Proposal</span>
                    <a href="{{ url('proposal/create') }}" class="btn btn-primary btn-sm">Add New Proposal</a>
                </div>
                <div class="card-body">
                    @if ($proposals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Number</th>
                                        <th>Year</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $proposal)
                                        <tr id="proposal-row-{{ $proposal->id }}">
                                            <td>{{ $proposal->number }}</td>
                                            <td>{{ $proposal->year ?? '-' }}</td>
                                            <td class="text-break" style="max-width:200px;">
                                                {{ $proposal->description ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $badge =
                                                        [
                                                            'pending' => 'warning',
                                                            'agreed' => 'success',
                                                            'rejected' => 'danger',
                                                        ][$proposal->status ?? ''] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $badge }}">
                                                    {{ ucfirst($proposal->status ?? '-') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ url('proposal/' . $proposal->id . '/edit') }}"
                                                    class="btn btn-warning btn-sm mb-1 mb-md-0">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $proposal->id }}">
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
                            No proposals found.
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
                    Are you sure you want to delete this proposal?
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
        let proposalIdToDelete = null;

        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            proposalIdToDelete = button.getAttribute('data-id');
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!proposalIdToDelete) {
                alert('ID not found!');
                return;
            }

            fetch("{{ url('proposal') }}/" + proposalIdToDelete, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById('proposal-row-' + proposalIdToDelete).remove();
                        var modal = bootstrap.Modal.getInstance(deleteModal);
                        modal.hide();
                    } else {
                        alert('Failed to delete proposal.');
                    }
                })
                .catch((e) => {
                    alert('Failed to delete proposal.');
                });
        });
    </script>
@endpush
