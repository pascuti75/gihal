function initConsultaIndex() {

    $(".campo_fecha").flatpickr({
        locale: "es"
    });

    $('#reset_f_oper_ini').click(function () {
        $('#f_oper_ini').val('');
    });

    $('#reset_f_oper_fin').click(function () {
        $('#f_oper_fin').val('');
    });

    $('#reset_cod_interno').click(function () {
        $('#cod_interno').val('');
    });

    $('#reset_num_serie').click(function () {
        $('#num_serie').val('');
    });

    $('#reset_product_number').click(function () {
        $('#product_number').val('');
    });


    autocompletar('cod_interno', 'cod_interno_list');
    autocompletar('product_number', 'product_number_list');
    autocompletar('num_serie', 'num_serie_list');

    function autocompletar(campo, campo_list) {
        $('#' + campo).keyup(function () {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "./autocompletar/" + campo,
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function (data) {
                        $('#' + campo_list).fadeIn();
                        $('#' + campo_list).html(data);
                    }
                });
            }
        });

        $(document).on('click', '#' + campo_list + ' li', function () {
            $('#' + campo).val($(this).text());
            $('#' + campo_list).fadeOut();
        });
    }

}


function initConsultaShow() {
    $("#btn_volver").click(function () {
        event.preventDefault();
        history.back();
    });


}


function initContratacionIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });
}


function initContratacionForm() {
    $(".campo_fecha").flatpickr({
        locale: "es"
    });

    $('#reset_fecha_inicio').click(function () {
        $('#fecha_inicio').val('');
    });

    $('#reset_fecha_fin').click(function () {
        $('#fecha_fin').val('');
    });
}

function initEquipoIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });

    $('[data-toggle="tooltip"]').tooltip();
}


function initOperacionForm() {
    $("form").submit(function () {
        $("#id_equipo").prop("disabled", false);
        $("#id_user").prop("disabled", false);
    });
}

function initOperacionIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });

}

function initPersonaIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });
}

function initTipoEquipoIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });
}

function initUbicacionIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });
}

function initUsuarioIndex() {
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        $("#boton-buscar").click();
    });
}