@extends('master')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Add New Proposal</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Proposal Data
                </div>
                <div class="card-body">
                    <form action="{{ url('proposal') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" name="year" id="year" class="form-control"
                                value="{{ old('year') }}" required>
                            @error('year')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" maxlength="255">{{ old('description') }}</textarea>
                            <small class="text-muted">Max 100 characters</small>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="agreed" {{ old('status') == 'agreed' ? 'selected' : '' }}>Agreed</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{ url('proposal') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const desc = document.getElementById('description');
            desc.addEventListener('input', function() {
                if (desc.value.length > 100) {
                    alert('Description cannot exceed 100 characters!');
                }
            });
        });
    </script>
@endsection
