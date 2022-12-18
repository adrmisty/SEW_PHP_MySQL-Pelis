<!DOCTYPE HTML>
<html lang="es">

<!-- Datos que describen el documento -->
<head>
    <meta charset="UTF-8" />
    <title>Base de datos de películas</title>
    <meta name="author" content="Adriana Rodríguez Flórez, UO282798" />
    <meta name="description" content="Gestión de una base de datos con MySQL (temática libre: CINE)" />
    <meta name="keywords" content="mysql,sql,base,datos,bd,gestion,servidor,cine" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <?php require 'Ejercicio7_BaseDatos.php'?> <!-- Incluir el código PHP que especifica la BD -->
    <link rel="stylesheet" type="text/css" href="Ejercicio7.css" />
</head>

<body>

    <header>
        <h1>Base de datos de CINE</h1>
        <h2>Películas, actores, directores y más</h2>
    </header>
    
    <fieldset>
            <legend>Gestión de la BD</legend>
            <nav>
            <a title="Inicio"
                    tabindex="1"
                    accesskey="h"
                    href="Ejercicio7.php">
                Inicio | </a>

            <a title="Loguear película"
                    tabindex="2"
                    accesskey="i"
                    href="Ejercicio7_LoguearPelicula.php">
                Loguear películas | </a>

            <a title="Mostrar información extensa sobre una película concreta"
                    tabindex="4"
                    accesskey="b"
                    href="Ejercicio7_BuscarPelicula.php">
                Buscar películas por nombre / </a>

            <a title="Buscar películas dirigidas por un director"
                    tabindex="5"
                    accesskey="d"
                    href="Ejercicio7_BuscarDirector.php">
                por director | </a>

            <a title="Eliminar películas"
                    tabindex="6"
                    accesskey="e"
                    href="Ejercicio7_Borrar.php">
                Eliminar películas | </a>

            <a title="Insertar datos cinematográficos en la tabla"
                    tabindex=7"
                    accesskey="i"
                    href="Ejercicio7_InsertarDatos.php">
                Añadir datos cinematográficos | </a>

            </nav>
        </fieldset>


    <form action='#' method='post' name='menu'>
        <h3>Comandos básicos</h3>

        <fieldset>
            <legend>Inicialización de la base de datos:</legend>

            <!-- Información acerca de esta BD -->
            <article>
                <h4>Acerca de la base de datos 'Cine'</h4>
                <p>Esta base de datos recopila información acerca de películas, pudiendo ser esta información:</p>
                <ul>
                    <li>Su director/a.</li>
                    <li>Su actor principal.</li>
                    <li>Su actriz principal.</li>
                    <li>Algún premio que haya ganado (por ej. un Globo de Oro u Óscar de una determinada categoría).</li>
                </ul>
            </article>

            <input type="submit" name = "crearBDCine" value="Crear base de datos 'Cine'" />
            <fieldset>
                <h4>Estado de la BD:</h4>
                <?php $_SESSION['bdcine']->getMensajeBD()?>
            </fieldset>

            <p>A continuación puede inicializar las tablas vacías (Película - Director - ActorPrincipal - ActrizPrincipal - Premio), o con datos de ejemplo: </p>
            <input type="submit" name = "crearTablaCine" value="Crear" />
            <input type="submit" name = "inicializar" value="Inicializar" />
            <fieldset>
                <h4>Estado de las tablas:</h4>
                <?php $_SESSION['bdcine']->getMensajeCrearTabla()?>
            </fieldset>

        </fieldset>
    </form>



    <footer>
        <p>Software y Estándares para la Web</p>
        <p>Grado en Ingeniería Informática del Software (Universidad de Oviedo)</p>
        <address>
            <p>Contacto: 
            <a href="mailto:UO282798@uniovi.es">Adriana Rodríguez Flórez (UO282798@uniovi.es)</a></p>
        </address>
    </footer>
</body>

</html>