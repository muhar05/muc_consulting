@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Edit Timesheet</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('timesheet.update', $timesheet->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', $timesheet->date) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timestart" class="form-label">Time Start</label>
                            <input type="time" name="timestart" id="timestart" class="form-control"
                                value="{{ old('timestart', substr($timesheet->timestart, 0, 5)) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="timefinish" class="form-label">Time Finish</label>
                            <input type="time" name="timefinish" id="timefinish" class="form-control"
                                value="{{ old('timefinish', substr($timesheet->timefinish, 0, 5)) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $timesheet->description) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('timesheet.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
