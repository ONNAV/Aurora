
<?= link_tag('template/jPlayer-2.9.2/dist/skin/blue.monday/css/jplayer.blue.monday.css') ?>
<script type="text/javascript" src="<?= base_url("template/jPlayer-2.9.2/lib/jquery.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("template/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("template/jPlayer-2.9.2/dist/add-on/jplayer.playlist.js") ?>"></script>


<script type="text/javascript">
//<![CDATA[
    $(document).ready(function () {

        $.ajax({
            url: "<?= site_url("Reproductor/getList2") ?>",
            dataType: "JSON",
            type: "POST",
            beforeSend: function () {

            },
            success: function (d) {
                var myPlaylist = new jPlayerPlaylist({
                    jPlayer: "#jquery_jplayer_N",
                    cssSelectorAncestor: ".jp_container_N"
                }, d.canciones, {
                    playlistOptions: {
                        enableRemoveControls: true
                    },
                    swfPath: "../../dist/jplayer",
                    supplied: "webmv, ogv, m4v, oga, mp3",
                    useStateClassSkin: true,
                    autoBlur: false,
                    smoothPlayBar: true,
                    keyEnabled: true,
                    audioFullScreen: true
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
            }

        });
    });
//]]>
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title" id="NombreCancion"></h4>
                    <p class="category" id="ArtistaCancion"></p>
                </div>
                <div class="card-content">
                    <div class="jp-video jp_container_N jp-video-360p" role="application" aria-label="media player">
                        <div class="jp-type-playlist">
                            <div id="jquery_jplayer_N" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-video-play">
                                    <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                                </div>
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                    <div class="jp-controls-holder">
                                        <div class="jp-controls">
                                            <button class="jp-previous" role="button" tabindex="0">previous</button>
                                            <button class="jp-play" role="button" tabindex="0">play</button>
                                            <button class="jp-next" role="button" tabindex="0">next</button>
                                            <button class="jp-stop" role="button" tabindex="0">stop</button>
                                        </div>
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                        </div>
                                        <div class="jp-toggles">
                                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                            <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                            <a role="button" tabindex="0" id="downmp3" download alt="Descargar Cancion"><i class="material-icons">file_download</i></a>
                                        </div>
                                    </div>
                                    <div class="jp-details">
                                        <div class="jp-title" aria-label="title">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title"><i class="material-icons">library_music</i> Lista de Canciones</h4>

                </div>
                <div class="card-content">
                    <div id="header">
                        <form class="filterform" action="#">
                        </form>
                    </div>

                    <div class="jp_container_N" id="containercanciones">
                        <div class="jp-type-playlist">
                            <div class="jp-playlist">
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                    <li>&nbsp;</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url("template/js/jquery-1.7.2.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url() ?>template/plugins/slimScroll/jquery.slimscroll.min.js?<?= $_SESSION['VersionJs'] ?>"></script>
<script>
    $("#containercanciones").slimScroll({
        height: 500
    });


</script>
<script>
    (function ($) {
        jQuery.expr[':'].Contains = function (a, i, m) {
            return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };

        function listFilter(header, list) {
            var form = $("<form>").attr({"class": "filterform", "action": "#"}),
                    input = $("<input>").attr({"class": "form-control filterinput", "type": "text", "placeholder": "Buscar..."});
            $(form).append(input).appendTo(header);

            $(input)
                    .change(function () {
                        var filter = $(this).val();
                        if (filter) {
                            $(list).find(".jp-playlist-item:not(:Contains(" + filter + "))").parent().parent().slideUp();
                            $(list).find(".jp-playlist-item:Contains(" + filter + ")").parent().slideDown();
                        } else {
                            $(list).find(".song").slideDown();
                        }
                        return false;
                    })
                    .keyup(function () {
                        $(this).change();
                    });
        }

        $(function () {
            listFilter($("#header"), $(".jp-playlist"));
        });
    }(jQuery));
</script> 
