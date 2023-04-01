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