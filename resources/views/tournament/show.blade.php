@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="h3">
                    Dettaglio torneo "{{ $tournament->name }}"
                </div>
                <small>
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i> indietro</a>
                </small>

                <div class="card m-3">
                    <div class="card-body">

                        <form method="POST" action="{{ route('tournament.update', [$season, $tournament]) }}">
                            @csrf
                            @method('put')
                            <div class="form-group col-md-12 pt-2">
                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $tournament->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="description"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                    <div class="col-md-6">
                                        <input id="description" type="text"
                                            class="form-control @error('description') is-invalid @enderror"
                                            name="description" value="{{ $tournament->description }}"
                                            autocomplete="description">

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Query') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror" name="address"
                                            value="{{ $tournament->query }}" required autocomplete="address">

                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10" style="text-align: right">
                                <button type="submit" class="btn btn-primary">Salva modifiche</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-between p-3">
                    <a href="{{ route('tournament.download_calendar', [$season, $tournament]) }}"
                        class="btn btn-outline-primary">
                        Scarica incontri
                    </a>
                    <a href="{{ route('tournament.download_results', [$season, $tournament]) }}"
                        class="btn btn-outline-primary">
                        Scarica risultati
                    </a>
                    <a href="{{ route('tournament.evaluate_classification', [$season, $tournament]) }}"
                        class="btn btn-outline-primary">
                        Aggiorna classifica
                    </a>
                </div>


                <br>
                <br>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="rounds-tab" data-bs-toggle="tab" data-bs-target="#rounds"
                            type="button" role="tab" aria-controls="rounds" aria-selected="true">Risultati</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking"
                            type="button" role="tab" aria-controls="ranking" aria-selected="false">Classifica</button>
                    </li>
                </ul>



                <div class="tab-content">
                    <br>
                    <div class="tab-pane fade-in active" id="last-match-tab">

                    </div>

                    <div class="tab-pane fade-in active" id="rounds">

                        <table class="table">
                            @foreach ($tournament->rounds() as $round)
                                <tr>
                                    <td colspan="7">
                                        <div class="h4 mt-4">
                                            Giornata {{ $round[0]->round }}
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($round as $result)
                                    <tr>
                                        <td>
                                            {{ $result->date }} {{ $result->time }}
                                        </td>
                                        <td>
                                            {{ $result->gym }}
                                            <br>
                                            {{ $result->location }}
                                        </td>
                                        <td>
                                            <div class="h5">
                                                {{ $result->home_team->name }} {{ $result->home_team->id }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h5">
                                                {{ $result->visitor_team->name }} {{ $result->visitor_team->id }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h5">
                                                {{ $result->home_set_won }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h5">
                                                {{ $result->visitor_set_won }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>

                    </div>

                    <div class="tab-pane fade-in active" id="ranking">


                        <table class="table">
                            <tr>
                                <td>
                                    Squadra
                                </td>
                                <td>
                                    Punti
                                </td>
                                <td>
                                    Set Vinti
                                </td>
                                <td>
                                    Set persi
                                </td>
                            </tr>
                        @foreach ($ranking as $team)
                                <tr>
                                    <td>
                                        <div class="h5">
                                            {{ $team->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="h5">
                                            {{ $team->pivot->score }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="h5">
                                            {{ $team->pivot->set_won }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="h5">
                                            {{ $team->pivot->set_lost }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>



                {{-- @foreach ($tournaments as $tournament)
                    {{ $tournament->name }}
                @endforeach --}}

            </div>
        </div>
    </div>
@endsection
