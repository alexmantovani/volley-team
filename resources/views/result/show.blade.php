@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="pt-2">
                            <p class="fs-3 text-black-50 pb-0 mb-0">Dettaglio partita: <span
                                    class="fw-bold fs-3 text-black-80">{{ $result->home_team->name }} -
                                    {{ $result->visitor_team->name }}</span>
                            </p>
                        </div>
                    </div>
                    <p class="text-uppercase">{{ $result->gym }} &middot; {{ $result->location }} - {{ $result->date }}
                        {{ $result->time }}</p>
                </div>

                @livewire('score-edit', [
                    'result' => $result,
                ])
            </div>
            <div class="clearfix">
                <div class="fotogallery-wrp">
                    <div class="txt-nofoto-wrp">
                        <p>Non sono presenti immagini per questa partita.</p>
                    </div>
                </div>

                {{-- <div class="file-upload-wrp">
                    <h4>Hai delle foto di questa partita?</h4>
                    <p>Se hai scattato delle foto di questa partita puoi condividerle con noi e con tutti gli utenti
                        del sito
                        COMITATO TERRITORIALE C.S.I. MILANO - APS!<br>
                        Inviaci le tue foto utilizzando il form qui sotto.</p>
                    <br><br>
                    <input id="fileupload" accept="image/png,image/jpeg" type="file" name="files[]" multiple>

                </div> --}}
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{-- <script src="/js/jquery.ui.widget.js"></script>
    <script src="/js/jquery.iframe-transport.js"></script>
    <script src="/js/jquery.fileupload.js"></script>
    <script>
        // When the server is ready...

        $(function() {
            'use strict';

            // Define the url to send the image data to
            var url = '/public/ajax/upload.php';

            // Call the fileupload widget and set some parameters
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                formData: {
                    incontro: $("#incontrofull").val()
                },
                start: function(e, data) {
                    $('#progress-wrp').show();
                    $('#progress .bar').css('width', '0');
                    $('#progress-wrp .txt').empty().text("AVANZAMENTO UPLOAD");
                },
                done: function(e, data) {
                    // Add each uploaded file name to the #files list
                    $.each(data.result.files, function(index, file) {
                        $('<div class="item-wrp"></div>').html(
                            '<div class="image-wrp"><img src="/media/partite/2022314BA0103/' +
                            file.name +
                            '"></div><p>Inserisci la didascalia</p><input type="hidden" name="ids_temp[]" value="' +
                            file.id_temp +
                            '"><input type="hidden" name="images_temp[]" value="/media/partite/2022314BA0103/' +
                            file.name +
                            '"><div class="dida-wrp"><input type="text" name="didascalia[]"><br><a href="/public/ajax/upload.php" rel="' +
                            file.id_temp + '" class="remove">RIMUOVI</a></div>').appendTo(
                            '#files');
                    });
                    $('.email-wrp').show();
                    $('#progress-wrp .txt').empty().text("UPLOAD TERMINATO");
                },
                progressall: function(e, data) {
                    // Update the progress bar while files are being uploaded
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css('width', progress + '%');
                    /*if (progress == 100) {
                     $('#progress-wrp').hide();
                     }*/
                }
            });
        });
    </script> --}}
@endpush
