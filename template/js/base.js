var anterior;
function loadPage(obj) {
    if (anterior == undefined) {
        anterior = obj;
    }

    $("#contenidopagina").load($(obj).attr('data-ref'), function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#contenidopagina").html(msg + xhr.status + " " + xhr.statusText + " <b>");
        }
    });



//    var direccion = 'http://localhost:86/index.php/' + $(obj).attr('data-ref');
//    $.ajax({url: direccion, type: 'post', complete: function (response) {
//            console.log(response);
//        }});

    $('.sidebar-menu li').each(function () {
        if ($(this).attr('data-ref') == $(obj).attr('data-ref') && $(obj)[0].firstChild.innerText == $(this)[0].firstChild.innerText) {
            $(obj).addClass('active');
        } else if ($(anterior).attr('data-ref') != $(obj).attr('data-ref') || $(obj)[0].firstChild.innerText != $(anterior.firstChild)[0].innerText) {
            $(anterior).removeClass('active');
        } else {
            // $(this).removeClass('active');
            console.log('else');
        }
    });
    anterior = obj;
}

$(".loadpage").click(function () {
    if (anterior == undefined) {
        anterior = $(this);
    }

    $("#contenidopagina").load($(this).attr('data-ref'), function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#contenidopagina").html(msg + xhr.status + " " + xhr.statusText + " <b>");
        }
    });



//    var direccion = 'http://localhost:86/index.php/' + $(obj).attr('data-ref');
//    $.ajax({url: direccion, type: 'post', complete: function (response) {
//            console.log(response);
//        }});

    $('.sidebar-menu li').each(function () {
        if ($(this).attr('data-ref') == $(this).attr('data-ref') && $(this)[0].firstChild.innerText == $(this)[0].firstChild.innerText) {
            $(this).addClass('active');
        } else if ($(anterior).attr('data-ref') != $(this).attr('data-ref') || $(this)[0].firstChild.innerText != $(anterior.firstChild)[0].innerText) {
            $(anterior).removeClass('active');
        } else {
            // $(this).removeClass('active');
            console.log('else');
        }
    });
    anterior = $(this);
});


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
    $('body').css('overflow-y', 'hidden');
    $('body').after('<div id="fondo"></div>');
    $('body').after('<div id="loading"><img id="cargando" style="width: 300px" src="http://media.tumblr.com/tumblr_lrnf2nIeAI1qim3b0.gif"/></div>');
}

function desbloquearPantalla()
{
    $('#fondo').remove();
    $('#loading').remove();
    $('body').css('overflow-y', 'unset');
}