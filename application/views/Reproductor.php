<?= link_tag('template/css/reproductor.css') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title"></h4>
                </div>
                <div class="card-content">
                    <div id="divReproductor">
                        <div id="divInfo">
                            <div id="divLogo">

                            </div>
                            <div id="divInfoCancion">
                                <label id="lblCancion"><strong>Nombre: </strong><span>-</span></label>
                                <label id="lblArtista"><strong>Artista: </strong><span>-</span></label>
                                <label id="lblDuracion"><strong>Duraci&oacute;n: </strong><span>-</span></label>
                                <label id="lblEstado"><strong>Transcurrido: </strong><span>-</span></label>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div id="divControles">
                            <input type="button" id="btnReproducir" title="Reproducir">
                            <input type="button" id="btnPausar" title="Pausar/Continuar">
                            <input type="button" id="btnAnterior" title="Anterior">
                            <input type="button" id="btnSiguiente" title="Siguiente">
                            <input type="button" id="btnSubirVolumen" title="Subir volumen">
                            <input type="button" id="btnBajarVolumen" title="Bajar volumen">
                            <input type="button" id="btnSilencio" title="Poner/Quitar silencio">
                            <input type="button" id="btnRepetir" title="Repetir la lista al finalizar">
                        </div>
                        <div id="divProgreso">
                            <div id="divBarra"></div>
                        </div>
                        <div id="divLista">
                            <ol id="olCanciones"></ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url("template/js/jquery-1.7.2.min.js") ?>"></script>

<script>
    function listaRepro() {
        $.ajax({
            url: "<?= base_url("index.php/Reproductor/getList") ?>",
            dataType: "JSON",
            type: "POST",
            beforeSend: function () {
//            $('body').css('overflow-y', 'hidden');
//            $('body').after('<div id="fondo"></div>');
//            $('body').after('<div id="loading"><img id="cargando" style="width: 300px" src="http://media.tumblr.com/tumblr_lrnf2nIeAI1qim3b0.gif"/></div>');
            },
            success: function (d) {
                $("#olCanciones").html(d.canciones);
                $.getScript("<?= base_url("template/js/reproductor.js") ?>");
                setTimeout(listaRepro(), 300000);
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
    }

    $(document).ready(function () {
        listaRepro();
    });
</script>
