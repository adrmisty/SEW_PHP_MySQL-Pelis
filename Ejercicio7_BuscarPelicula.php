<!DOCTYPE HTML>
<html lang="es">

<!-- Datos que describen el documento -->
<head>
    <meta charset="UTF-8" />
    <title>Base de datos de películas</title>
    <meta name="author" content="Adriana Rodríguez Flórez, UO282798" />
    <meta name="description" content="Gestión de una base de datos con MySQL (temática libre: CINE) --- BUSCAR " />
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
                    tabindex="7"
                    accesskey="i"
                    href="Ejercicio7_InsertarDatos.php">
                Añadir datos cinematográficos </a>

            </nav>
        </fieldset>

    <form method="post" action="#" >
        <fieldset>
            <h3>Mostrar la información de...</h3>

            <label for="nombreBuscar">* Nombre de la película: </label>  
                <select id="nombreBuscar" name="nombreBuscar">
                    <option value="---">---</option>
                    <?php $_SESSION['bdcine']->getOpcionPeliculas()?>
                </select>

                <input type="submit" name="buscar" value="Buscar" />
        </fieldset>

        <section>
        <h4>Resultado de la búsqueda: </h4>
            <?php $_SESSION['bdcine']->getMensajeBuscarDatos()?>
        </section>
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