@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="h3">
                    Stagioni
                </div>
                <br>
                <div>
                    <form method="POST" action="{{ route('season.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <label for="name" class="col-form-label">{{ __('Nome della nuova stagione') }}</label>

                            &nbsp;&nbsp;&nbsp;

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    placeholder="es: Stagione 2022/23" value="{{ old('name') }}" required
                                    autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            &nbsp;&nbsp;&nbsp;

                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> &nbsp;&nbsp;
                                    {{ __('Aggiungi nuova stagione') }}
                                </button>
                            </div>
                    </form>
                </div>
            </div>

            @php $activeSeason = App\Models\Season::active(); @endphp
            @if ($activeSeason)
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="h3">
                            Stagione in corso
                        </div>
                        <table class="table table-borderless align-middle">
                            <tr>
                                <td>
                                    <a href="{{ route('season.show', $activeSeason) }}" class="h5">
                                        {{ $activeSeason->name }}
                                    </a>
                                </td>
                            </tr>
                            @foreach ($activeSeason->tournaments as $tournament)
                                <tr>
                                    <td>
                                        <div class="pl-5" style="padding-left: 40px">
                                            <a href="{{ route('tournament.show', [$activeSeason, $tournament]) }}">
                                                {{ $tournament->name }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif

            <div class="h3 pt-4">
                Elenco stagioni
            </div>

            <div class=" pt-3">
                <table class="table table-borderless align-middle">
                    @foreach ($seasons as $season)
                        @if ($activeSeason)
                            @if ($season->id == $activeSeason->id)
                                @continue
                            @endif
                        @endif
                        <tr>
                            <td class="h5">
                                {{ $season->name }}
                            </td>
                            <td style="width: 30px">
                                <a href="{{ route('season.show', $season) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                            </td>
                        </tr>

                        @foreach ($season->tournaments as $tournament)
                            <tr>
                                <td>
                                    <div class="pl-5" style="padding-left: 40px">
                                        <a href="{{ route('tournament.show', [$season, $tournament]) }}">
                                            {{ $tournament->name }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                </table>
            </div>
        </div>

    </div>
@endsection
