@extends('layouts.app')

@section('content')

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
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_consultor)
    <div id="section-9" class="card mt-3 section">
        <div class="card-body">
            <h3 class="card-title"><strong>Consultas</strong>
            </h3>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    @endif
</div>

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