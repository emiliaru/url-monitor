@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Monitorowane strony</h1>
        <a href="{{ route('websites.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj stronę
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Ostatnie sprawdzenie</th>
                    <th>Interwał</th>
                    <th>Kategoria</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($websites as $website)
                    <tr>
                        <td>{{ $website->name }}</td>
                        <td>
                            <a href="{{ $website->url }}" target="_blank">
                                {{ $website->url }}
                            </a>
                        </td>
                        <td>
                            @if($website->latestCheck)
                                @if($website->latestCheck->is_up)
                                    <span class="badge bg-success">Online</span>
                                @else
                                    <span class="badge bg-danger">Offline</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Brak danych</span>
                            @endif
                        </td>
                        <td>
                            {{ $website->last_check_at ? $website->last_check_at->diffForHumans() : 'Nigdy' }}
                        </td>
                        <td>{{ $website->check_interval }} min</td>
                        <td>{{ $website->category ?: 'Brak' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('websites.show', $website) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('websites.edit', $website) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('websites.check', $website) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <form action="{{ route('websites.destroy', $website) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tę stronę?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
