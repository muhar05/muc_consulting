@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Add Timesheet</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('timesheet.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timestart" class="form-label">Time Start</label>
                            <input type="time" name="timestart" id="timestart" class="form-control"
                                value="{{ old('timestart') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timefinish" class="form-label">Time Finish</label>
                            <input type="time" name="timefinish" id="timefinish" class="form-control"
                                value="{{ old('timefinish') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="employees_id" class="form-label">Employee</label>
                            <select name="employees_id" id="employees_id" class="form-control" required>
                                <option value="">-- Select Employee --</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ old('employees_id') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="proposal_id" class="form-label">Proposal Number</label>
                            <select name="proposal_id" id="proposal_id" class="form-control" required>
                                <option value="">-- Select Proposal --</option>
                                @foreach ($proposals as $proposal)
                                    <option value="{{ $proposal->id }}">{{ $proposal->number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="serviceused_id" class="form-label">Service Used</label>
                            <select name="serviceused_id" id="serviceused_id" class="form-control" required>
                                <option value="">-- Select Service Used --</option>
                                {{-- Options akan diisi otomatis oleh JS --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="add-btn">Add</button>
                        <a href="{{ route('timesheet.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                    <div id="no-serviceused-message" class="alert alert-warning d-flex align-items-center mt-3"
                        style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                            aria-label="Warning:">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.707c.89 0 1.438-.99.982-1.767L8.982 1.566zm-.982 4.905a.905.905 0 1 1 1.81 0l-.35 3.507a.552.552 0 0 1-1.11 0L8 6.47zm.002 6.02a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                        <div>
                            <strong>Tidak ada Service Used untuk proposal ini.</strong><br>
                            Silakan buat <b>Service Used</b> terlebih dahulu untuk menambahkan timesheet ini.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const serviceuseds = @json($serviceuseds);

        document.addEventListener('DOMContentLoaded', function() {
            const proposalSelect = document.getElementById('proposal_id');
            const serviceusedSelect = document.getElementById('serviceused_id');
            const noServiceusedMessage = document.getElementById('no-serviceused-message');
            const addBtn = document.getElementById('add-btn');

            function setAddBtnState(enabled) {
                addBtn.disabled = !enabled;
                if (enabled) {
                    addBtn.classList.remove('btn-secondary');
                    addBtn.classList.add('btn-primary');
                } else {
                    addBtn.classList.remove('btn-primary');
                    addBtn.classList.add('btn-secondary');
                }
            }

            function filterServiceused() {
                const proposalId = proposalSelect.value;
                serviceusedSelect.innerHTML = '<option value="">-- Select Service Used --</option>';
                let found = false;
                serviceuseds.forEach(function(su) {
                    if (su.proposal_id == proposalId) {
                        const option = document.createElement('option');
                        option.value = su.id;
                        option.text = su.service_name;
                        serviceusedSelect.appendChild(option);
                        found = true;
                    }
                });
                noServiceusedMessage.style.display = found ? 'none' : 'block';
                setAddBtnState(found);
                // Set old value jika ada
                @if (old('serviceused_id'))
                    serviceusedSelect.value = "{{ old('serviceused_id') }}";
                @endif
            }

            proposalSelect.addEventListener('change', filterServiceused);

            // Set old value saat load
            @if (old('proposal_id'))
                proposalSelect.value = "{{ old('proposal_id') }}";
                filterServiceused();
            @else
                setAddBtnState(false);
            @endif
        });
    </script>
@endpush
