@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
