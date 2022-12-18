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
                Añadir datos cinematográficos | </a>

            </nav>
        </fieldset>

    <form method="post" action="#" name="insertar_pelicula" >
        <fieldset>
        <h3>Inserción de filas en la tabla 'Pelicula'</h3>
                <p>
                    <label for="nombre_pelicula">* Nombre de la película: </label>  
                    <input id="nombre_pelicula" name="nombre_pelicula" type="text" maxlength="100" required />
                </p>
                
                
                <label for="genero">Género: </label>  
                <select id="genero" name ="genero">
                    <option value="---">---</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Aventura">Aventura</option>
                    <option value="Comedia">Comedia</option>
                    <option value="Romántica">Romántica</option>
                    <option value="Terror">Terror</option>
                    <option value="Sci-fi">Sci-fi</option>
                    <option value="Histórica">Histórica</option>
                    <option value="Musical">Musical</option>
                    <option value="Animación">Animación</option>
                    <option value="Otro">Otro</option>
                </select>

                <p>
                <label for="año">* Año de estreno de la película: </label>  
                    <input id="año" name="año" type="number" min="1900" max="2023" />
                </p>

                <p>
                <label for="duracion">Duración (minutos): </label>  
                    <input id="duracion" name="duracion" type="number" min="0" max="500" />
                </p>

                <label for="nombre_directorPeli">* Nombre del director: </label>  
                <select id="nombre_directorPeli" name="nombre_directorPeli">
                    <option value="---">---</option>
                    <?php $_SESSION['bdcine']->getOpcionDirectores()?>
                </select>

                <label for="nombre_actorPeli">* Nombre del actor principal: </label>  
                <select id="nombre_actorPeli" name ="nombre_actorPeli">
                    <option value="---">---</option>
                    <?php $_SESSION['bdcine']->getOpcionActores()?>
                </select>

                <label for="nombre_productoraPeli">* Nombre de la compañía cinematográfica productora: </label>  
                <select id="nombre_productoraPeli" name="nombre_productoraPeli">
                    <option value="---">---</option>
                    <?php $_SESSION['bdcine']->getOpcionProductoras()?>
                </select>

                <label for="nombre_premioPeli">Nombre del mayor premio ganado: </label>  
                <select id="nombre_premioPeli" name="nombre_premioPeli">
                    <option value="---">---</option>
                    <?php $_SESSION['bdcine']->getOpcionPremios()?>
                </select>

                <p>
                <label for="valoracion">Valoración de la película (sobre 5): </label>  
                    <input id="valoracion" name="valoracion" type="number" min="0" max="5" />
                </p>

                <p>
                <label for="opinion">Opinión: </label>  
                    <input id="opinion" name="opinion" type="text" maxlength="100" />
                </p>

                <input type="submit" name="insertarPelicula" value="Loguear película" />

                <section><h4>Resultado: </h4>
                <?php $_SESSION['bdcine']->getMensajeInsertarPelicula()?></section>
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