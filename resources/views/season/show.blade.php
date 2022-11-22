@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="d-flex">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Dettaglio <span
                                    class="fw-bold fs-3">{{ $season->name }}</span>


                            </p>
                            {{-- <small>
                                <a href="{{ route('season.index') }}"><i class="fa fa-angle-left"></i> indietro</a>
                            </small> --}}
                            <span class="badge p-2 indicator"
                                style="background-color: rgb(18, 141, 1); color: rgb(255, 255, 255); display: {{ $season->is_active ? 'block' : 'none' }} ">
                                IN CORSO
                            </span>
                        </div>
                        <div class="mt-3">

                            <div class="custom-switch custom-switch-label pt-2"
                                style=" display: {{ $season->is_active ? 'none' : 'block' }}"
                                title="Questo campionato diventerà quello in corso e sarà quello visibile sul sito">
                                <input class="custom-switch-input" id="active_season" name="active_season"
                                    onclick='handleClick(this);' type="checkbox" data-id="{{ $season->id }}" />
                                <label class="custom-switch-btn" for="active_season"></label>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('season.destroy', $season->id) }}"
                            onclick="return confirm('Vuoi davvero eliminare questa stagione?');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm fa p-0 m-0" style="color: red;height: 80px">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>


                <div class="row">

                    <div class="col-lg-8">
                        <div class="card h-100 m-3">
                            <div class="card-body">

                                <form method="POST" action="{{ route('season.update', $season) }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group col-md-12 pt-2">
                                        <div class="row mb-3">
                                            <label for="name"
                                                class="col-md-2 col-form-label text-md-end">{{ __('Name') }}</label>

                                            <div class="col-md-9">
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ $season->name }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="description"
                                                class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>

                                            <div class="col-md-9">
                                                <input id="description" type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    name="description" value="{{ $season->description }}"
                                                    autocomplete="description">

                                                @error('description')
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

                    </div>
                    <div class="col-lg-4">
                        <div class="card m-3 h-100">
                            <div class="card-body">

                                aaa
                            </div>
                        </div>
                    </div>
                </div>





                <table class="tbl-standard charts top-scorers">
                    @foreach ($season->tournaments as $tournament)
                        <tr>
                            <td>
                                <a href="{{ route('tournament.show', [$season, $tournament]) }}">
                                    {{ $tournament->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <a href="{{ route('tournament.create', $season) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;
                    {{ __('Aggiungi nuovo torneo') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleClick(element) {
            $.ajax({
                url: "{{ route('season.activate', $season->id) }}"
            }).done(function(data) {
                var item = document.getElementById('active_season');
                // item.style.display = 'none'; // Hide
                console.log("Done" + $(item).value + data);
            });
        }
    </script>
@endpush
