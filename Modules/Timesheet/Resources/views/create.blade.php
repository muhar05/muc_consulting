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
                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timestart" class="form-label">Time Start</label>
                            <input type="time" name="timestart" id="timestart" class="form-control" value="{{ old('timestart') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timefinish" class="form-label">Time Finish</label>
                            <input type="time" name="timefinish" id="timefinish" class="form-control" value="{{ old('timefinish') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="employees_id" class="form-label">Employee</label>
                            <select name="employees_id" id="employees_id" class="form-control" required>
                                <option value="">-- Select Employee --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ old('employees_id') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="serviceused_id" class="form-label">Service Used</label>
                            <select name="serviceused_id" id="serviceused_id" class="form-control" required>
                                <option value="">-- Select Service Used --</option>
                                @foreach($serviceuseds as $su)
                                    <option value="{{ $su->id }}" {{ old('serviceused_id') == $su->id ? 'selected' : '' }}>
                                        {{ $su->service_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{ route('timesheet.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection