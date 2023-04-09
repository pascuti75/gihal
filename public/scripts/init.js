
//funcion incializadora javascript para plantilla blade consulta/index.blade.php
function initConsultaIndex() {

    //vinculacion de calendario flatpickr a campos de tipo fecha
    $(".campo_fecha").flatpickr({
        locale: "es"
    });

    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
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

    //vinculacion de funcionalidad autocompletar en campos
    autocompletar('cod_interno', 'cod_interno_list');
    autocompletar('product_number', 'product_number_list');
    autocompletar('num_serie', 'num_serie_list');

    //funcion autocompletar.
    //parámetro campo: campo al que se le va a sociar el evento keyup para hacer las búsquedas
    //parámetro campo_list: campo dode se va a cargar la lista de rseultados por semejanza ala busqueda
    function autocompletar(campo, campo_list) {
        //funcionalidad para el evento keyup de los campos indicados
        $('#' + campo).keyup(function () {
            //recuperamos el valor a buscar
            var query = $(this).val();
            if (query != '') {
                //recuperamos el token para poder hacer la petición POST
                var _token = $('input[name="_token"]').val();
                //peticion ajax para recuperar los resultados en función del parámetro de búsqueda
                $.ajax({
                    url: "./autocompletar/" + campo,
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function (data) { //si todo es ok
                        //mostramos el campo de listado
                        $('#' + campo_list).fadeIn();
                        //cargamos el html obtenido
                        $('#' + campo_list).html(data);
                    }
                });
            }
        });

        //vinculamos el evento click del listado de la lista de resultados de autocompletar
        $(document).on('click', '#' + campo_list + ' li', function () {
            //cargamos el valor seleccionado en el campo principal
            $('#' + campo).val($(this).text());
            //ocultamos la lista de resultados
            $('#' + campo_list).fadeOut();
        });
    }

}


//funcion incializadora javascript para plantilla blade consulta/show.blade.php
function initConsultaShow() {
    //vinculación con el evento click deñ botón volver
    $("#btn_volver").click(function () {
        //anula el comportamiento de envío desde el botón
        event.preventDefault();
        //vuelve a la pagía desde la que ha venido
        history.back();
    });


}

//funcion incializadora javascript para plantilla blade contratacion/index.blade.php
function initContratacionIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });
}

//funcion incializadora javascript para plantilla blade contratacion/form.blade.php
function initContratacionForm() {
    //vinculacion de calendario flatpickr a campos de tipo fecha
    $(".campo_fecha").flatpickr({
        locale: "es"
    });

    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $('#reset_fecha_inicio').click(function () {
        $('#fecha_inicio').val('');
    });

    $('#reset_fecha_fin').click(function () {
        $('#fecha_fin').val('');
    });
}

//funcion incializadora javascript para plantilla blade equipo/index.blade.php
function initEquipoIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });

    //activamos la funcionalidad tooltip a los elementos que contienen el atributo  data-toggle="tooltip"
    $('[data-toggle="tooltip"]').tooltip();
}


//funcion incializadora javascript para plantilla blade operaciones/form.blade.php
function initOperacionForm() {
    //al enviar el formulario deshabilitamos los campos con identificadores id_equipo y id_user
    $("form").submit(function () {
        $("#id_equipo").prop("disabled", false);
        $("#id_user").prop("disabled", false);
    });
}

//funcion incializadora javascript para plantilla blade operacion/index.blade.php
function initOperacionIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });

}

//funcion incializadora javascript para plantilla blade persona/index.blade.php
function initPersonaIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });
}

//funcion incializadora javascript para plantilla blade tipo_equipo/index.blade.php
function initTipoEquipoIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });
}

//funcion incializadora javascript para plantilla blade ubicacion/index.blade.php
function initUbicacionIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });
}

//funcion incializadora javascript para plantilla blade usuario/index.blade.php
function initUsuarioIndex() {
    //Vinculamos la limpieza del campo al pulsar sobre el botón reset 
    $("#boton-reset").on('click', function (event) {
        $('#query').val('');
        //lanzamos el evento click del botón-buscar para que cargue la vista con la información completa
        $("#boton-buscar").click();
    });
}

