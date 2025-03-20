@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ $website->name }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Informacje podstawowe</h4>
                            <dl class="row">
                                <dt class="col-sm-4">URL:</dt>
                                <dd class="col-sm-8">
                                    <a href="{{ $website->url }}" target="_blank">{{ $website->url }}</a>
                                </dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    @if($website->latestCheck)
                                        @if($website->latestCheck->is_up)
                                            <span class="badge bg-success">Online</span>
                                        @else
                                            <span class="badge bg-danger">Offline</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Brak danych</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Interwał:</dt>
                                <dd class="col-sm-8">{{ $website->check_interval }} minut</dd>

                                <dt class="col-sm-4">Kategoria:</dt>
                                <dd class="col-sm-8">{{ $website->category ?: 'Brak' }}</dd>

                                <dt class="col-sm-4">Status aktywności:</dt>
                                <dd class="col-sm-8">
                                    @if($website->is_active)
                                        <span class="badge bg-success">Aktywna</span>
                                    @else
                                        <span class="badge bg-danger">Nieaktywna</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Ostatnie sprawdzenie:</dt>
                                <dd class="col-sm-8">
                                    {{ $website->last_check_at ? $website->last_check_at->format('Y-m-d H:i:s') : 'Nigdy' }}
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h4>Akcje</h4>
                            <div class="btn-group">
                                <a href="{{ route('websites.edit', $website) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edytuj
                                </a>
                                <form action="{{ route('websites.check', $website) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i> Sprawdź teraz
                                    </button>
                                </form>
                                <form action="{{ route('websites.destroy', $website) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Czy na pewno chcesz usunąć tę stronę?')">
                                        <i class="fas fa-trash"></i> Usuń
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Historia sprawdzeń</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Kod odpowiedzi</th>
                                    <th>Czas odpowiedzi</th>
                                    <th>Błąd</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($website->checks as $check)
                                    <tr>
                                        <td>{{ $check->checked_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            @if($check->is_up)
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <span class="badge bg-danger">Offline</span>
                                            @endif
                                        </td>
                                        <td>{{ $check->status_code ?: 'N/A' }}</td>
                                        <td>
                                            @if($check->response_time)
                                                {{ number_format($check->response_time, 3) }}s
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $check->error_message ?: 'Brak' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
