@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="h3">
                    Stagioni
                </div>
                <br>
                <div>
                    <form method="POST" action="{{ route('season.store') }}" enctype="multipart/form-data" class="row d-flex">
                        @csrf

                        <div class="row mb-3">
                            <label for="name"
                                class="col-md-3 col-form-label text-md-end">{{ __('Nome della nuova stagione') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> &nbsp;&nbsp;
                                    {{ __('Aggiungi nuova stagione') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <br>

                    <div class="row">
                        <table class="table table-borderless align-middle">
                            @foreach ($seasons as $season)
                            <tr>
                                <td>
                                    <a href="{{ route('season.show', $season) }}">
                                        {{ $season->name }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endsection
