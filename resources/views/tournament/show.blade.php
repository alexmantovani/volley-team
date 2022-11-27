@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Torneo <span
                                    class="fw-bold fs-3">{{ $tournament->name }}</span>
                            </p>
                            <small>
                                <a onclick="window.history.back();"><i class="fa fa-angle-left"></i> indietro</a>
                            </small>
                        </div>

                        <form method="POST" action="{{ route('tournament.destroy', [$season->id, $tournament->id]) }}"
                            onclick="return confirm('Vuoi davvero eliminare questo torneo?');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-danger mt-3">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @livewire('tournament-show', [
                    'season' => $season,
                    'tournament' => $tournament,
                    ])

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function handleClick(element) {
            var stato = document.getElementById('sync_tournament').checked;
            $.ajax({
                url: "{{ route('tournament.sync', [$season->id, $tournament->id]) }}?checked=" + stato
            }).done(function(data) {
                //TODO: disabilito i 2 pulsanti "Scarica incontri e risultati"
                // item.style.display = 'none'; // Hide
                console.log("Done " + data);
            });
        }
    </script>
@endpush
