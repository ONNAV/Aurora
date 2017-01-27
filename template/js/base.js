function loadContent(ref) {
    $("#contenidopagina").load(ref, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#contenidopagina").html(msg + xhr.status + " " + xhr.statusText + " <b>");
        }
    });
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getPhrase() {
    var num = getRandomInt(1, 3);
    switch (num) {
        case 1   :
            return "<center><h4>Hay tiempo suficiente, pero no hay nada de sobra.</h4><p> - Charles W. Chesnutt</p></center>";
            break;
        case 2  :
            return "<center><h4>Todo lo que tenemos que decidir es qué hacer con el tiempo que se nos da </h4> <p>- Gandalf</p></center>";
            break;
    }
}

function bloqueoPantalla()
{
    i = getRandomInt(1, 4);
    $('body').css('overflow-y', 'hidden');
    $('body').after('<div id="fondo"></div>');
    $('body').after('<div id="loading"><img id="cargando" style="width: 300px" src="' + base + 'template/gif/' + i + '.gif"/></div>');
}

function desbloquearPantalla()
{
    $('#fondo').remove();
    $('#loading').remove();
    $('body').css('overflow-y', 'unset');
}