@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Edit Proposal</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('proposal.update', $proposal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" name="number" id="number" class="form-control"
                                value="{{ old('number', $proposal->number) }}" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" maxlength="100">{{ old('description', $proposal->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending"
                                    {{ old('status', $proposal->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="agreed" {{ old('status', $proposal->status) == 'agreed' ? 'selected' : '' }}>
                                    Agreed</option>
                                <option value="rejected"
                                    {{ old('status', $proposal->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('proposal.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
