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
                                        <th>Employee ID</th>
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
                                            <td>{{ $item->employees_id }}</td>
                                            <td>{{ $item->serviceused_id }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <a href="{{ route('timesheet.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
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
@endsection
