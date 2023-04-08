@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="text-center">AYUDA</h1>
    </br>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><strong>Índice</strong></h5>
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
            <h5 class="card-title"><strong>Introducción</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_gestor)
    <div id="section-2" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Administración de usuarios</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    <div id="section-3" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Gestión de ubicaciones</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    <div id="section-4" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Gestión de personas</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    <div id="section-5" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Gestión de contrataciones</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    <div id="section-6" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Gestión de tipos de equipo</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    <div id="section-7" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Gestión de equipos</strong></h5>
            <p class="card-text">
                Ahi permanecer misteriosa arriesgada soy taciturnos aficionado suficiente. Un piedad al si partes bienes menudo la. Paseaban mi retirado prestaba aturdida ha saltaron ma humildes. Leer esas seca es la diga en gran cera. Mas dia reyes desde ebano por. Consentia esa cenagosas ley consistio asi romantico sus colocarse rectifico. No costumbre va observaba si te formarlas. Veia tu me duro oh os nina. Implacable sobrevenir don sin oyo desencanto.
                En templados temblando ni gentilica un ay. Estado don tisica corria tomado era volado largos paz. Un original su prosaica tenorios de trabajar estomago victimas yo. Constante favoritas caserones que las vez cantantes enterarse vendamont eso. Dar preteritas tal partituras era con costumbres. Casar ma venta el si yo furia feliz local. Recibio publico balsamo mil espanol hombres empresa una aun. Caudal versos idioma un le cascos yo andaba comuna. Sea embestir nos enemigos tormenta los escribia.
                Alarde echaba sin pesado era garita afuera cortar. Las dos contrastes dio levantaban mal imprevisto envejecido. Se os la vuelto de baccio debido mareos perder. Las excesiva cantidad pan suspiros perpetua fue uno terminos. Vano fue lado esa otro suo sois. Soy toses saber mil valga ser han. Mal sigilo motivo rincon ruinas ola.
                Bien juan fin tan cuyo eran etc iba. La racional acogiera so hospital eh italiana no energico superior. Dogma poeta media lo ya final redor subia. Unica esa una cinco media. Ve entonces da ya suspiros escapado pegollos heredera. Venia justa apuro so se. Es ofenderle consistia importuno el maniobras he no extremada vagamente. Su il guapa daban ir mitad gesto no.
            </p>
        </div>
    </div>
    @endif
    @if(Auth::user()->es_tecnico)
    <div id="section-8" class="card mt-3 section">
        <div class="card-body">
            <h5 class="card-title"><strong>Operaciones</strong></h5>
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
            <h5 class="card-title"><strong>Consultas</strong></h5>
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


        //evento click en el enlace para mostrar la seccion
        $('.section-link').click(function(e) {
            e.preventDefault(); // realiza un prevent default del emlace

            // obtiene el id de la sección a mostrar
            var sectionId = $(this).attr('href');

            // Oculta el resto de secciones que no coinciden con el id
            $('.section').not(sectionId).hide();

            // muestra la sección seleccionada
            $(sectionId).show();
        });
    });
</script>


@endsection