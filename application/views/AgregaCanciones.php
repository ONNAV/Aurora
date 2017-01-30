<?= link_tag("template/dropzone/dropzone.css") ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Agregar Cancion Desde URL (<i class="fa fa-youtube" aria-hidden="true"></i> | <i class="fa fa-soundcloud" aria-hidden="true"></i>)</h4>
                    <p class="category">Youtube ó Soundcloud</p>
                </div>
                <div class="card-content">
                    <form id="frmcancion">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">URL</label>
                                    <input type="url" required id="url" name="BibliotecaMusicalStream[URL]" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" name="BibliotecaMusicalStream[Titulo]" id="Titulo" class="form-control" required >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Artista</label>
                                    <input type="text" name="BibliotecaMusicalStream[Artista]" id="Artista" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Album</label>
                                    <input type="text" name="BibliotecaMusicalStream[Album]" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Año</label>
                                    <input type="number" name="BibliotecaMusicalStream[Ano]" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Genero</label>
                                    <input type="text" name="BibliotecaMusicalStream[Genero]" id="Genero" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <button type="sumbit" class="btn btn-success pull-right">Voy a tener suerte</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" data-background-color="orange">
                    <h4 class="title">Subir una cancion</h4>
                </div>
                <div class="card-content">
                    <form action="<?= base_url("index.php/Reproductor/UploadDrop") ?>" id="frmdropzone" class="dropzone"></form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Vista Previa</h4>
                </div>
                <div class="card-content">
                    <iframe id="soundcloud_widget"src="" width="100%" frameborder="no" style="display: none"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://w.soundcloud.com/player/api.js"></script>
<script>
    $(document).ready(function () {
        var myDropzone = new Dropzone("#frmdropzone", {maxFilesize: 50, acceptedFiles: '.mp3,.m4a'});

        myDropzone.on("complete", function (file, json, xhr) {
            $.notify({
                icon: json.icon,
                message: json.text

            }, {
                type: (json.error) ? 'danger' : 'success',
                timer: 4000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                }
            });
            setTimeout(function () {
                myDropzone.removeFile(file);
            }, 10000);
        });

        myDropzone.on("error", function (xhr, ajaxOptions, thrownError) {
            $.notify({
                icon: "notifications",
                message: "Ocurrio un error tratando de subir el archivo " + xhr.name

            }, {
                type: 'danger',
                timer: 4000,
                placement: {
                    from: 'bottom',
                    align: 'center'
                }
            });
        });
    });
</script>
<script type="text/javascript" src="<?= base_url("template/dropzone/dropzone.js") ?>"></script>
<script>

    function getSoundCloudInfo() {
        var url = $('#url').val();
        var regexp = /^https?:\/\/(soundcloud\.com|snd\.sc)\/(.*)$/;
        if (url.match(regexp) && url.match(regexp)[2]) {
            client_id = 'a3e059563d7fd3372b49b37f00a00bcf';
            $.get('http://api.soundcloud.com/resolve.json?url=' +
                    url + '/tracks&client_id=' + client_id, function (result) {
                        $("#Genero").val(result.genre);
                        $("#Titulo").val(result.title);
                        $("#Artista").val(result.user.username);
                        $("#soundcloud_widget").attr('src', 'http://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/' + result.id + '&show_artwork=false&liking=false&sharing=false&auto_play=true');
                        var widget = SC.Widget(document.getElementById('soundcloud_widget'));
                        widget.bind(SC.Widget.Events.READY, function () {
                            //$("#videoObject").hide();
                            $("#soundcloud_widget").show();
                            console.log('Ready...');
                        });
                        $('.playButton__overlay').click(function () {
                            widget.toggle();
                        });
                    });
        } else {
            alert('not valid');
        }
    }

    function validateYouTubeUrl() {
        var url = $('#url').val();
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                $('#soundcloud_widget').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
                $("#soundcloud_widget").show();
            } else {
                alert('not valid');
            }
        }
    }
    $("#url").bind("change", function (e) {
        if (isYouTubeUrl()) {
            setTimeout(validateYouTubeUrl(), 5000);
        } else if (isSoundCloudUrl()) {
            setTimeout(getSoundCloudInfo(), 5000);
        }
    });
    function isYouTubeUrl() {
        var url = $('#url').val();
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                return true;
            } else {
                return false;
            }
        }
    }
    function isSoundCloudUrl() {
        var url = $('#url').val();
        var regexp = /^https?:\/\/(soundcloud\.com|snd\.sc)\/(.*)$/;
        if (url.match(regexp) && url.match(regexp)[2]) {
            return true;
        } else {
            return false;
        }
    }

    $("#frmcancion").submit(function () {
        $.ajax({
            "url": "<?= base_url("index.php/Reproductor/UploadFromURL") ?>",
            "dataType": "json",
            type: "post",
            data: $(this).serialize(),
            beforeSend: function () {
                bloqueoPantalla();
            },
            complete: function (json) {
                desbloquearPantalla();

                $.notify({
                    icon: json.responseJSON.icon,
                    message: json.responseJSON.text

                }, {
                    type: (json.responseJSON.error) ? 'danger' : 'success',
                    timer: 2500,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $.notify({
                    message: xhr.responseText

                }, {
                    type: 'danger',
                    timer: 4000,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    }
                });
                //alertify.alert().set({'startMaximized': true, 'title': '<h1>Mensaje de Envio</h1>', 'message': xhr.responseText}).show();
            }

        });


        return false;
    });
</script>