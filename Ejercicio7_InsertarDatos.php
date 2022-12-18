<!DOCTYPE HTML>
<html lang="es">

<!-- Datos que describen el documento -->
<head>
    <meta charset="UTF-8" />
    <title>Base de datos de películas</title>
    <meta name="author" content="Adriana Rodríguez Flórez, UO282798" />
    <meta name="description" content="Gestión de una base de datos con MySQL (temática libre: CINE) --- INSERTAR DATOS " />
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

    <form method="post" action="#" name="insertar_actor" >
        <fieldset>
        <h3>Cree un nuevo 'Actor' o 'Actriz'</h3>
                <p>
                    <label for="nombre_actor">* Nombre (artístico) del actor: </label>  
                    <input id="nombre_actor" name="nombre_actor" type="text" maxlength="100" required />
                </p>
                <p>
                    <label for="nombre_real_actor">* Nombre (real) del actor: </label>  
                    <input id="nombre_real_actor" name="nombre_real_actor" type="text" maxlength="100" />
                </p>
                <p>
                    <label for="lugar_actor">* Lugar de nacimiento del actor: </label>  
                    <input id="lugar_actor" name="lugar_actor" type="text" maxlength="100" />
                </p>
                <p>
                    <label for="fecha_actor">* Fecha de nacimiento: </label> 
                    <input id="fecha_actor" name="fecha_actor" type="date" required />
                </p>

                <input type="submit" name="insertarActor" value="Insertar actor" />

                <section><h4>Resultado: </h4>
                <?php $_SESSION['bdcine']->getMensajeInsertarActor()?></section>
        </fieldset>
    </form>

    <form method="post" action="#" >
        <fieldset>
        <h3>Cree una nueva 'Productora'</h3>
                <p>
                    <label for="nombre_productora">* Nombre de la productora: </label>  
                    <input id="nombre_productora" name="nombre_productora" type="text" maxlength="100" required />
                </p>
                <p>
                    <label for="sede">* Sede de la productora: </label>  
                    <input id="sede" name="sede" type="text" maxlength="100" />
                </p>
                <p>
                    <label for="creacion">* Fecha de fundación: </label> 
                    <input id="creacion" name="creacion" type="date" required />
                </p>
                <input type="submit" name="insertarProductora" value="Insertar productora" />

                <section><h4>Resultado: </h4>
                <?php $_SESSION['bdcine']->getMensajeInsertarProductora()?></section>
            </fieldset>
        </form>

        <form method="post" action="#" name="insertar_director" >
            <fieldset>
            <h3>Cree un nuevo 'Director'</h3>
                <p>
                    <label for="nombre_director">* Nombre del director: </label>  
                    <input id="nombre_director" name="nombre_director" type="text" maxlength="100" required />
                </p>
                <p>
                    <label for="fecha_director">* Fecha de nacimiento: </label> 
                    <input id="fecha_director" name="fecha_director" type="date" required />
                </p>
                <p>
                    <label for="lugar_director">* Lugar de nacimiento del director: </label>  
                    <input id="lugar_director" name="lugar_director" type="text" maxlength="100" required />
                </p>
                <p>
                    <label for="corriente">* Corriente cinematográfica: </label>  
                    <input id="corriente" name="corriente" type="text" maxlength="100" />
                </p>

                <input type="submit" name="insertarDirector" value="Insertar director" />

                <section><h4>Resultado: </h4>
                <?php $_SESSION['bdcine']->getMensajeInsertarDirector()?></section>
            </fieldset>
        </form>

        <form method="post" action="#" name="insertar_premio" >
            <fieldset>
            <h3>Cree un nuevo 'Premio'</h3>
                <p>
                    <label for="cod_premio">* Código de id. del premio: </label>  
                    <input id="cod_premio" name="cod_premio" type="text" maxlength="5" required />
                </p>

                <p>
                    <label for="nombre_premio">* Nombre del premio: </label>  
                    <input id="nombre_premio" name="nombre_premio" type="text" maxlength="100" required />
                </p>
                <p>
                    <label for="categoria">* Categoría : </label>  
                    <input id="categoria" name="categoria" type="text" maxlength="100" />
                </p>

                <input type="submit" name="insertarPremio" value="Insertar premio" />

                <section><h4>Resultado: </h4>
                <?php $_SESSION['bdcine']->getMensajeInsertarPremio()?></section>
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