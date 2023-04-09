{{-- Plantilla blade para mostrar la ayuda --}}

{{-- Extendemos la plantilla base layouts.app --}}
@extends('layouts.app')

{{-- Definimos la sección content --}}
@section('content')

{{-- En la plantilla vamos a mostrar/ocultar secciones html en funcion del tipo de perfil de accesos a la aplicacion--}}

<div class="container">
    <h1 class="text-center">AYUDA</h1>
    </br>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><strong>Índice</strong>
            </h3>
            <p class="card-text">
            <div class="list-group">
                <a href="#section-1" class="list-group-item list-group-item-action section-link ">- Introducción</a>
                @if(Auth::user()->es_administrador)
                <a href="#section-2" class="list-group-item list-group-item-action section-link ">- Administración de usuarios</a>
                @endif
                @if(Auth::user()->es_gestor)
                <a href="#section-3" class="list-group-item list-group-item-action section-link ">- Gestión de ubicaciones</a>
                <a href="#section-4" class="list-group-item list-group-item-action section-link ">- Gestión de personas</a>
                <a href="#section-5" class="list-group-item list-group-item-action section-link ">- Gestión de contrataciones</a>
                <a href="#section-6" class="list-group-item list-group-item-action section-link ">- Gestión de tipos de equipo</a>
                <a href="#section-7" class="list-group-item list-group-item-action section-link ">- Gestión de equipos</a>
                @endif
                @if(Auth::user()->es_tecnico)
                <a href="#section-8" class="list-group-item list-group-item-action section-link ">- Operaciones</a>
                @endif
                @if(Auth::user()->es_consultor)
                <a href="#section-9" class="list-group-item list-group-item-action section-link ">- Consultas</a>
                @endif
            </div>
            </p>
        </div>
    </div>
    @if(Auth::user()->es_administrador)
    <div id="section-1" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Introducción</strong>
            </h3>
            <div class="card-text">
                <p> GIHAL es una aplicación de gestión de activos hardware para entidades
                    locales o públicas. Es decir son entidades que tienen material hardware propio pero también
                    dependen de licitaciones con empresas para renting de material, con fechas de finalización para la
                    devolución del material.</p>
                <p>El fin de la aplicación es tener localizado el lugar de instalación del
                    material y la persona asignada, con el fin de tener un control sobre el material que tiene cada
                    persona o donde está ubicado para por ejemplo retirarlo cuando se produzca un fin de licitación.
                    También permite conocer el historial de operaciones sobre un equipo.</p>
                <p>Las distintas funcionalidades de la aplicación están limitdas por el tipo de perfil/es de acceso que
                    tenga asignado el usuario que esté utilizando la aplicación.</p>
                <p>La aplicación distingue 4 tipos de perfiles de acceso:</p>
                <ul>
                    <li><strong>Administrador:</strong> Perfil que permite administar los usuarios de la aplicación
                        (creación, edición, eliminación y asignación de perfil/es de acceso)</li>
                    <li><strong>Gestor:</strong> Perfil que gestiona (creación, edición y eliminación) las contrataciones, las ubicaciones,
                        los usuarios de la entidad, los tipos de equipo y los equipos.</li>
                    <li><strong>Técnico:</strong> Perfil que realiza las distintas operaciones (almacenaje, instalación, reparación y baja) sobre los equipos.</li>
                    <li><strong>Consultor:</strong> Perfil que permite analizar la distinta información de las operaciones realizadas mediante la aplicación de filtros
                        de búsqueda.</li>
                </ul>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_gestor)
    <div id="section-2" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Administración de usuarios</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la administración (creación, edición, baja y búsqueda) de los distintos usuarios que van a hacer uso de la aplicación,
                    limitando las funcionalidades en función del perfil/es de acceso que se le asigne.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de usuarios dados de alta en la aplicación, mostrandose también información sobre los distintos
                    perfiles de acceso asignados</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Usuario, Administrador, Gestor, Técnico y Consultor.</li>
                    <li><strong>Acción - Crear Usuario:</strong> Accede al formulario "Ficha de Usuario" para la creación de usuarios.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Usuario" para la edición del usuario referenciado en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar al usuario referenciado en la fila. No es posible eliminar usuarios asociados a operaciones.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Usario - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el alta, definición de contraseña y perfiles de acceso de un usuario.</p>
                </br>
                <h5><strong>Ficha de Usario - Editar</strong></h5>
                <p>Permite modificar la información relativa a la contraseña y los perfiles de acceso.</p>
            </div>
        </div>
    </div>
    <div id="section-3" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Gestión de ubicaciones</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la gestión (creación, edición, baja y búsqueda) de las distintas ubicaciones de los servicios y dependencias de la entidad donde puede ubicarse un equipo.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de ubicaciones registradas en la aplicación</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Servicio, Dependencia, Dirección y Planta.</li>
                    <li><strong>Acción - Crear Ubicación:</strong> Accede al formulario "Ficha de Ubicación" para la creación de ubicaciones.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Ubicación" para la edición de la ubicación referenciada en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar a la ubicación referenciada en la fila. No es posible eliminar ubicaciones asociadas a operaciones.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Ubicación - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el registro de una ubicación.</p>
                </br>
                <h5><strong>Ficha de Ubicación - Editar</strong></h5>
                <p>Permite modificar toda la información relativa a la ubicación.</p>
            </div>
        </div>
    </div>
    <div id="section-4" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Gestión de personas</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la gestión (creación, edición, baja y búsqueda) de las distintas personas de la entidad a los que puede asociarse un equipo mediante una operación.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de personas registradas en la aplicación</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Nombre, Apellidos y Tipo.</li>
                    <li><strong>Acción - Crear Persona:</strong> Accede al formulario "Ficha de Persona" para la creación de personas.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Persona" para la edición de la persona referenciada en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar a la persona referenciada en la fila. No es posible eliminar personas asociadas a operaciones.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Persona - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el registro de una persona.</p>
                </br>
                <h5><strong>Ficha de Persona - Editar</strong></h5>
                <p>Permite modificar toda la información relativa a la persona.</p>
            </div>
        </div>
    </div>
    <div id="section-5" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Gestión de contrataciones</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la gestión (creación, edición, baja y búsqueda) de las distintas contrataciones/licitaciones para la adquisición/alquiler/renting de equipos.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de contrataciones registradas en la aplicación</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Título y Empresa.</li>
                    <li><strong>Acción - Crear Contratación:</strong> Accede al formulario "Ficha de Contratación" para el registro de contrataciones/licitaciones.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Contratación" para la edición de la información de la contratación referenciada en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar a la contratación/licitación referenciada en la fila. No es posible eliminar contrataciones asociadas a equipos.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Contratación - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el registro de una contratación/licitación.</p>
                </br>
                <h5><strong>Ficha de Contratación - Editar</strong></h5>
                <p>Permite modificar toda la información relativa a la contratación/licitación.</p>
            </div>
        </div>
    </div>
    <div id="section-6" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Gestión de tipos de equipo</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la gestión (creación, edición, baja y búsqueda) de los tipos de equipo en los que pueden clasificarse a los equipos.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de tipos de equipo registrados en la aplicación</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Código y Tipo.</li>
                    <li><strong>Acción - Crear Tipo:</strong> Accede al formulario "Ficha de Tipo de Equipo" para la creación de tipos de equipo.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Tipo de Equipo" para la edición del tipo de equipo referenciado en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar al tipo de equipo referenciado en la fila. No es posible eliminar tipos de equipo asociados a equipos.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Tipo de Equipo - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el registro de un tipo de equipo.</p>
                </br>
                <h5><strong>Ficha de Tipo de Equipo - Editar</strong></h5>
                <p>Permite modificar la información relativa al tipo.</p>
            </div>
        </div>
    </div>
    <div id="section-7" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Gestión de equipos</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza la gestión (creación, edición, baja y búsqueda) de los equipos pertenecientes a la entidad.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado equipos registrados en la aplicación</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Marca, Modelo, Cod. Interno, Cod. externo, Num. Serie, Product Number y Tipo de Equipo</li>
                    <li><strong>Acción - Crear Equipo:</strong> Accede al formulario "Ficha de Equipo" para la creación del equipo.</li>
                    <li><strong>Acción - Editar:</strong> Accede al formulario "Ficha de Equipo" para la edición del equipo referenciado en la fila.</li>
                    <li><strong>Acción - Eliminar:</strong> Permite eliminar el equipo referenciado en la fila. No es posible eliminar equipos asociados a operaciones.</li>
                    <li><strong>Acción - Ver:</strong> Al colocar el cursor sobre la acción muestra la información de la contratación asociada al equipo en el caso que exista.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Equipo - Crear</strong></h5>
                <p>Dispone de los campos necesarios para el registro Equipo. Al registrar un nuevo equipo se está generando a la vez una operación de almacenaje del equipo.</p>
                </br>
                <h5><strong>Ficha de Equipo - Editar</strong></h5>
                <p>Permite modificar toda la información relativa al equipo.</p>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_tecnico)
    <div id="section-8" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Operaciones</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se realiza todas las operaciones de almacenaje, envío a reparación, instalación y baja de los equipos de la entidad.</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de operaciones activas</p>
                <p>Disponemos de las siguientes funcionalidades</p>
                <ul>
                    <li><strong>Cuadro de búsqueda:</strong> Permite realizar búsquedas de forma conjunta en los campos: Tipo Operación, Tipo de Equipo, Código Interno del Equipo, Persona, Ubicación y Técnico</li>
                    <li><strong>Acción - ins (instalación):</strong> Accede al formulario "Ficha de Operación" para generar una nueva operación de instalación del equipo referenciado en la fila. No se puede realizar una operación sobre un equipo dado de baja.</li>
                    <li><strong>Acción - alm (almacenaje):</strong> Genera una nueva operación de envío a almacen sobre del equipo referenciado en la fila. Esta operación quedará marcada como activa. El resto de operaciones asociadas al equipo pasaran a NO activas. No se puede realizar una operación sobre un equipo dado de baja.</li>
                    <li><strong>Acción - rep (envío a reparación):</strong> Genera una nueva operación de envío a reparación sobre del equipo referenciado en la fila. Esta operación quedará marcada como activa. El resto de operaciones asociadas al equipo pasaran a NO activas. No se puede realizar una operación sobre un equipo dado de baja.</li>
                    <li><strong>Acción - baja (baja):</strong> Genera una nueva operación de baja sobre del equipo referenciado en la fila. Esta operación quedará marcada como activa. El resto de operaciones asociadas al equipo pasaran a NO activas. No se puede realizar una operación sobre un equipo dado de baja.</li>
                </ul>
                </br>
                <h5><strong>Ficha de Operación - Instalación</strong></h5>
                <p>Dispone de los campos necesarios para definir la operación de instalación sobre el equipo. Podemos indicar a la persona y en la ubicación donde se va a realizar la operación de instalación. Al finalizar, esta operación quedará marcada como activa. El resto de operaciones asociadas al equipo pasaran a NO activas</p>

            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_consultor)
    <div id="section-9" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Consultas</strong>
            </h3>
            <div class="card-text">
                <p>Desde está sección se puede realizar multiples consultas sobre todas las operaciones realizadas (tanto activas cómo no activas).</p>
                </br>
                <h5><strong>Listado</strong></h5>
                <p>Muestra de forma tabulada y con paginación, el listado de operaciones. Estas operaciones son el resultado de la consulta a partir de la aplicación de los filtros. Si no se utilizan los filtros se muestran todas las operaciones.</p>
                <p>Sólo se aplica en la consulta los filtros que se han rellenado. Disponemos de los siguientes filtros:</p>
                <ul>
                    <li><strong>Cod.Interno:</strong> Autocompletable. Código interno del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Técnico:</strong> Seleccionable. Técnico que ha realizado la operación.</li>
                    <li><strong>Persona:</strong> Seleccionable. Persona a la que se le ha vinculado el equipo al realizar la operación.</li>
                    <li><strong>Ubicación:</strong> Seleccionable. Ubicación a la que se le ha vinculado el equipo al realizar la operación.</li>
                    <li><strong>Tipo de operación:</strong> Seleccionable. Tipo de operación aplicable a la operación.</li>
                    <li><strong>Desde fecha operación:</strong> Completable. Fecha de operación desde la cual se va a realizar la búsqueda.</li>
                    <li><strong>Hasta fecha operación:</strong> Completable. Fecha de operación hasta la cual se va a realizar la búsqueda.</li>
                    <li><strong>Tipo de Equipo:</strong> Seleccionable. Tipo del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Marca:</strong> Seleccionable. Marca del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Modelo:</strong> Seleccionable. Modelo del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Product Number:</strong> Autocompletable. Product Number del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Número de Serie:</strong> Autocompletable.Número de Serie del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Contratación:</strong> Seleccionable. Contratación al que pertenece, en el caso que sea, del equipo al que se ha aplicado la operación.</li>
                    <li><strong>Mostrar sólo operaciones activas:</strong> Marcable. Muestra sólo en los resultados de la búsqueda las operaciones activas.</li>
                </ul>
                </br>
                <p>Disponemos de las siguientes acciones</p>
                <ul>
                    <li><strong>Ver:</strong> Muestra la ficha de operación de la operación referenciada en la fila.</li>
                    <li><strong>Exportar a PDF:</strong> Genera y descarga un archivo pdf con una tabla con los resultados de la búsqueda.</li>
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Cargamos la funcionalidad Javascript --}}
<script>
    $(document).ready(function() {

        //inicialmente todas las secciones van a estar ocultas
        $('.section').hide();

        //definición de evento click en los enlaces para mostrar la seccion
        $('.section-link').click(function(e) {
            e.preventDefault(); // realiza un prevent default del enlace

            // obtiene el id de la sección a mostrar
            var sectionId = $(this).attr('href');

            // Oculta el resto de secciones que no coinciden con el id
            $('.section').not(sectionId).hide();

            // muestra la sección seleccionada
            $(sectionId).show();

            //colocamos el foco en la sección seleccionada
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top
            }, 300);
        });
    });
</script>


@endsection