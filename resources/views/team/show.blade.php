@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Squadra: <span
                                    class="fw-bold fs-3">{{ $team->name }}</span>
                            </p>
                            <small>
                                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i> indietro</a>
                            </small>
                        </div>

                        {{-- <form method="POST" action="{{ route('tournament.destroy', [$season->id, $tournament->id]) }}"
                            onclick="return confirm('Vuoi davvero eliminare questo torneo?');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-danger mt-3">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form> --}}
                    </div>
                </div>


                <div class="d-flex">
                    <div class="pt-2">
                        E' una squadra di questa società &nbsp;
                    </div>
                    <div class="custom-switch custom-switch-label pt-2">
                        <input class="custom-switch-input" id="my_team" type="checkbox"
                         {{-- wire:click="updateAlert"
                            wire:model="showNotice"  --}}
                            />
                        <label class="custom-switch-btn" for="my_team"> </label>
                    </div>
                </div>




                {{-- @livewire('tournament-show', [
                    'season' => $season,
                    'tournament' => $tournament,
                    ]) --}}

            </div>
        </div>
    </div>
@endsection
