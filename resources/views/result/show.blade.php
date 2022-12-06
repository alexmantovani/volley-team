@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

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

                <div class="row">
                    <div class="">
                        @livewire('score-edit', [
                            'result' => $result,
                        ])
                    </div>


                </div>
                <div class="">
                    <form method="post" action="{{ url('gallery') }}" enctype="multipart/form-data" class="dropzone"
                        id="dropzone">
                        <div class="dz-default dz-message">
                            <h4>Trascina qui le immagini dell'incontro</h4>
                        </div>
                    </form>
                </div>



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
    <script>
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        Dropzone.options.myDropzone = {
            paramName: "file",
            maxFilesize: 100, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    formData.append("_token", CSRF_TOKEN);
                    // formData.append('paziente', $('input[name="paziente"]:checked').val());
                    // formData.append('medico', $('input[name="medico"]:checked').val());
                    // formData.append('sole', $('input[name="sole"]:checked').val());
                });
            },
            queuecomplete: function(file, response) {
                console.log(file + ' ' + response);
                location.reload();
            }
        };
    </script>
@endpush

{{-- @push('scripts')
    <script>
        Dropzone.options.dropzone = {
            maxFiles: 5,
            maxFilesize: 4,
            //~ renameFile: function(file) {
            //~ var dt = new Date();
            //~ var time = dt.getTime();
            //~ return time+"-"+file.name;    // to rename file name but i didn't use it. i renamed file with php in controller.
            //~ },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            init: function() {

                // Get images
                var myDropzone = this;
                $.ajax({
                    url: gallery,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        //console.log(data);
                        $.each(data, function(key, value) {

                            var file = {
                                name: value.name,
                                size: value.size
                            };
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                            myDropzone.emit("complete", file);
                        });
                    }
                });
            },
            removedfile: function(file) {
                if (this.options.dictRemoveFile) {
                    return Dropzone.confirm("Are You Sure to " + this.options.dictRemoveFile, function() {
                        if (file.previewElement.id != "") {
                            var name = file.previewElement.id;
                        } else {
                            var name = file.name;
                        }
                        //console.log(name);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: delete_url,
                            data: {
                                filename: name
                            },
                            success: function(data) {
                                alert(data.success + " File has been successfully removed!");
                            },
                            error: function(e) {
                                console.log(e);
                            }
                        });
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    });
                }
            },

            success: function(file, response) {
                file.previewElement.id = response.success;
                //console.log(file);
                // set new images names in dropzone’s preview box.
                var olddatadzname = file.previewElement.querySelector("[data-dz-name]");
                file.previewElement.querySelector("img").alt = response.success;
                olddatadzname.innerHTML = response.success;
            },
            error: function(file, response) {
                if ($.type(response) === "string")
                    var message = response; //dropzone sends it's own error messages in string
                else
                    var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }

        };
    </script>
@endpush --}}
