@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Edit Service Used</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('serviceused.update', $serviceused->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="proposal_id" class="form-label">Proposal</label>
                            <select name="proposal_id" id="proposal_id" class="form-control" required>
                                @foreach ($proposals as $proposal)
                                    <option value="{{ $proposal->id }}"
                                        {{ $serviceused->proposal_id == $proposal->id ? 'selected' : '' }}>
                                        {{ $proposal->number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="service_name" class="form-label">Nama Service</label>
                            <input type="text" name="service_name" id="service_name" class="form-control"
                                value="{{ $serviceused->service_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ $serviceused->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="ongoing" {{ $serviceused->status == 'ongoing' ? 'selected' : '' }}>Ongoing
                                </option>
                                <option value="done" {{ $serviceused->status == 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('serviceused.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
