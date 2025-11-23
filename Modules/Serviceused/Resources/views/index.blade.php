@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <h2>Service Used List</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                    <span>All Service Used</span>
                    <a href="{{ route('serviceused.create') }}" class="btn btn-primary btn-sm">Tambah Service Used</a>
                </div>
                <div class="card-body">
                    @if ($serviceuseds->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Proposal Number</th>
                                        <th>Nama Service</th>
                                        <th>Status</th>
                                        <th>Timespent</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($serviceuseds as $item)
                                        <tr>
                                            <td>{{ $item->proposal_number }}</td>
                                            <td class="text-break" style="max-width:200px;">{{ $item->service_name }}</td>
                                            <td>
                                                @php
                                                    $badge =
                                                        [
                                                            'pending' => 'warning',
                                                            'ongoing' => 'info',
                                                            'done' => 'success',
                                                        ][$item->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $badge }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $hours = floor($item->timespent / 60);
                                                    $minutes = $item->timespent % 60;
                                                    printf('%02d:%02d', $hours, $minutes);
                                                @endphp
                                            </td>
                                            <td>
                                                <a href="{{ route('serviceused.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm mb-1 mb-md-0">Edit</a>
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
                            No service used found.
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
                    Are you sure you want to delete this service?
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
            let serviceusedIdToDelete = null;

            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                serviceusedIdToDelete = button.getAttribute('data-id');
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (!serviceusedIdToDelete) {
                    alert('ID not found!');
                    return;
                }

                fetch("{{ url('serviceused') }}/" + serviceusedIdToDelete, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            document.querySelector('button[data-id="' + serviceusedIdToDelete + '"]').closest('tr')
                                .remove();
                            var modal = bootstrap.Modal.getInstance(deleteModal);
                            modal.hide();
                        } else {
                            alert('Failed to delete service.');
                        }
                    })
                    .catch((e) => {
                        alert('Failed to delete service.');
                    });
            });
        </script>
    @endpush
@endsection
