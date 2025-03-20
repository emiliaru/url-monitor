@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2>Dodaj nową stronę</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('websites.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nazwa</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                id="url" name="url" value="{{ old('url') }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="check_interval" class="form-label">Interwał sprawdzania (minuty)</label>
                            <input type="number" class="form-control @error('check_interval') is-invalid @enderror" 
                                id="check_interval" name="check_interval" value="{{ old('check_interval', 5) }}" required min="1">
                            @error('check_interval')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategoria</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                id="category" name="category" value="{{ old('category') }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Zapisz
                            </button>
                            <a href="{{ route('websites.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Powrót
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
