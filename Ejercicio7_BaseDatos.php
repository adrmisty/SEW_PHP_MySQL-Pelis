
<?php

session_start();

/*
    Representación de una base de datos con MySQL
    Temática libre: CINE
    @author Adriana R.F. - UO282798
*/
class BaseDatos {

    // Constantes: cuenta de MySQL
    private $servername = "localhost";
    private $username = "DBUSER2022";
    private $password = "DBPSWD2022";

    private $contarActores = "SELECT * FROM actor";
    private $contarProductoras = "SELECT * FROM productora";
    private $contarDirectores = "SELECT * FROM director";
    private $contarPremios = "SELECT * FROM premio";
    private $contarPeliculas = "SELECT * FROM pelicula";
    private $buscarDatos = "SELECT * FROM pelicula WHERE nombre_pelicula=?";
    private $buscarDirector = "SELECT * FROM director WHERE nombre_director=?";
    private $buscarActor = "SELECT * FROM actor WHERE nombre_actor=?";
    private $buscarDatosPorDirector = "SELECT * FROM pelicula WHERE nombre_director=?";
    private $buscarProductora = "SELECT * FROM productora WHERE nombre_productora=?";
    private $buscarPremio = "SELECT * FROM premio WHERE cod_premio=?";
    private $buscarCodPremio = "SELECT cod_premio FROM premio WHERE nombre_premio=? and categoria=?";
    private $borrarDatos = "DELETE FROM pelicula WHERE nombre_pelicula=?";

    // Creación de la base de datos
    private $crearBase = "CREATE DATABASE IF NOT EXISTS cine COLLATE utf8_spanish_ci";

    // Tabla película, que referencia a una pelicula, actor, actriz, premio, así como el resto de información
    // MySQL no soporta CHECK constraints
    private $crearTablaPelicula = 
        "CREATE TABLE IF NOT EXISTS Pelicula ( 
        nombre_pelicula VARCHAR(255),
        nombre_actor VARCHAR(255) NOT NULL,  
        nombre_productora VARCHAR(255) NOT NULL,
        nombre_director VARCHAR(255) NOT NULL,
        cod_premio VARCHAR(20),
        año int NOT NULL,
        valoracion int NOT NULL,
        duracion int NOT NULL,
        opinion VARCHAR(255),
        genero VARCHAR(255),
        CONSTRAINT pk_pelicula PRIMARY KEY (nombre_pelicula),
        CONSTRAINT fk_pelicula_actor FOREIGN KEY (nombre_actor) REFERENCES actor(nombre_actor),
        CONSTRAINT fk_pelicula_productora FOREIGN KEY (nombre_productora) REFERENCES productora(nombre_productora),
        CONSTRAINT fk_pelicula_director FOREIGN KEY (nombre_director) REFERENCES director(nombre_director),
        CONSTRAINT fk_pelicula_premio FOREIGN KEY (cod_premio) REFERENCES premio(cod_premio))";

    // Actor y su información principal
    private $crearTablaActor = 
        "CREATE TABLE IF NOT EXISTS Actor ( 
        nombre_actor VARCHAR(255),
        fecha_nacimiento DATE NOT NULL,  
        nombre_real VARCHAR(255),
        lugar_nacimiento VARCHAR(255) NOT NULL,
        CONSTRAINT pk_actor PRIMARY KEY (nombre_actor))";

    // Comapñía cinematográfica
    private $crearTablaProductora = 
        "CREATE TABLE IF NOT EXISTS Productora ( 
        nombre_productora VARCHAR(255),
        sede VARCHAR(255),
        año_creacion int NOT NULL,  
        CONSTRAINT pk_productora PRIMARY KEY (nombre_productora))";

    // Director y su información principal
    private $crearTablaDirector = 
        "CREATE TABLE IF NOT EXISTS Director ( 
        nombre_director VARCHAR(255),
        fecha_nacimiento DATE NOT NULL,  
        lugar_nacimiento VARCHAR(255) NOT NULL,
        corriente VARCHAR(255),
        PRIMARY KEY(nombre_director))";

    // Cantidad de premios ganados
    private $crearTablaPremio = 
        "CREATE TABLE IF NOT EXISTS Premio ( 
        cod_premio VARCHAR(20),
        nombre_premio VARCHAR(255),
        categoria VARCHAR(255),
        CONSTRAINT pk_premio PRIMARY KEY (cod_premio))";

    private $insertarActor = 
    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) VALUES (?,?,?,?)";
    private $insertarProductora = 
    "INSERT INTO productora (nombre_productora, sede, año_creacion) VALUES (?,?,?)";
    private $insertarDirector = 
    "INSERT INTO director (nombre_director, fecha_nacimiento, lugar_nacimiento, corriente) VALUES (?,?,?,?)";
    private $insertarPremio = 
    "INSERT INTO premio (cod_premio,nombre_premio, categoria) VALUES (?,?,?)";
    private $insertarPelicula = 
    "INSERT INTO pelicula (nombre_pelicula, nombre_actor, nombre_productora, nombre_director, cod_premio, año, valoracion, duracion, opinion,genero) VALUES (?,?,?,?,?,?,?,?,?,?)";

    // Mensaje devuelto
    private $mensajeCreacionBD = "<p>No creada/conectada.</p>";
    private $mensajeCrearTabla = "<p>No inicializadas.</p>";
    private $mensajeBuscarDatos = "<p>Todavía no ha realizado una búsqueda.</p>";
    private $mensajeBorrarDatos = "<p>Todavía no ha realizado ningún borrado.</p>";
    private $mensajeInsertarActor = "<p>Todavía no se ha insertado un nuevo actor.</p>";
    private $mensajeInsertarProductora = "<p>Todavía no se ha insertado una nueva productora.</p>";
    private $mensajeInsertarDirector = "<p>Todavía no se ha insertado un nuevo director.</p>";
    private $mensajeInsertarPremio = "<p>Todavía no se ha insertado un nuevo premio.</p>";
    private $mensajeInsertarPelicula = "<p>Todavía no se ha logueado una nueva película.</p>";
    private $mensajeBuscarDirector = "<p>Todavía no ha realizado una búsqueda.</p>";

    // Base de datos
    private $db;

    function __constructor(){}

    public function getMensajeBD(){
        echo $this->mensajeCreacionBD;
    }

    public function getMensajeCrearTabla(){
        echo $this->mensajeCrearTabla;
    }

    public function getMensajeInsertarActor(){
        echo $this->mensajeInsertarActor;
    }

    public function getMensajeInsertarProductora(){
        echo $this->mensajeInsertarProductora;
    }

    public function getMensajeInsertarDirector(){
        echo $this->mensajeInsertarDirector;
    }

    public function getMensajeInsertarPremio(){
        echo $this->mensajeInsertarPremio;
    }

    public function getMensajeInsertarPelicula(){
        echo $this->mensajeInsertarPelicula;
    }

    public function getMensajeBuscarDatos(){
        echo $this->mensajeBuscarDatos;
    }

    public function getMensajeModificarDatos(){
        echo $this->mensajeModificarDatos;
    }

    public function getMensajeBuscarDirector(){
        echo $this->mensajeBuscarDirector;
    }


    public function getMensajeBorrarDatos(){
        echo $this->mensajeBorrarDatos;
    }



    // Borra los datos en la tabla de usabilidad
    public function borrarTabla(){
        $this->db->query($this->borrarTabla);
    }

    // Reinicia los mensajes de la interfaz de usuario
    public function reiniciarMensajes(){
        $this->mensajeInsertarFila = "<p>Todavía no se ha insertado nueva información.</p>";
        $this->mensajeBorrarDatos = "<p>Todavía no ha realizado ningún borrado.</p>";            
        $this->mensajeBuscarDatos = "<p>Todavía no ha realizado ninguna búsqueda.</p>";            
        $this->mensajeModificarDatos = "<p>Todavía no se ha realizado ninguna modificación.</p>";
        $this->mensajeInforme = "<p>Todavía no ha generado el informe.</p>";
        $this->mensajeImportarCSV = "<p>Todavía no ha seleccionado un archivo para importar.</p>";
        $this->mensajeExportarCSV = "<p>Todavía no se ha realizado la exportación de la BD.</p>";    
        $this->mensajeInsertarActor = "<p>Todavía no se ha insertado un nuevo actor.</p>";
        $this->mensajeInsertarProductora = "<p>Todavía no se ha insertado una nueva productora.</p>";
        $this->mensajeInsertarDirector = "<p>Todavía no se ha insertado un nuevo director.</p>";
        $this->mensajeInsertarPremio = "<p>Todavía no se ha insertado un nuevo premio.</p>";
        $this->mensajeInsertarPelicula = "<p>Todavía no se ha logueado una nueva película.</p>";    
    }

    // Creación de una base de datos
    public function crearBD(){
        // Conexión al DBMS local
        $this->db = new mysqli($this->servername,$this->username,$this->password);


        // Comprobar correcta conexión
        if ($this->db->connect_error){
            $this->mensajeCreacionBD="<p>ERROR de conexión: ". $this->db->connect_error . "</p>";
            exit();
        } else {
            $this->mensajeCreacionBD="<p>Conexión establecida con: ". $this->db->host_info . "</p>";
                    // En caso afirmativo, crear la BD
            if ($this->db->query($this->crearBase) === TRUE){
                $this->mensajeCreacionBD=$this->mensajeCreacionBD . "<p>Base de datos 'Cine' creada con éxito</p>";
            } else {
                $this->mensajeCreacionBD= $this->mensajeCreacionBD . ". ERROR en la creación de la base de datos 'Cine': " . $this->db->error;
                exit();
            } 
        }

    }

    // Creación de la tablas vacías
    public function crearTablas(){

        if ($this->mensajeCreacionBD === "<p>No inicializadas.</p>"){
            $this->mensajeCrearTabla="<p>No se puede crear la tabla si no se ha conectado primero a la BD.</p>";
        } else {
            $this->crearBD();
            $this->db->select_db("cine");

            $director = $this->db->query($this->crearTablaDirector) === TRUE;
            $actor = $this->db->query($this->crearTablaActor) === TRUE;
            $productora = $this->db->query($this->crearTablaProductora) === TRUE;
            $premio = $this->db->query($this->crearTablaPremio) === TRUE;
            $pelicula = $this->db->query($this->crearTablaPelicula) === TRUE;

            if ($director && $actor && $productora && $premio && $pelicula){
                $this->mensajeCrearTabla="<p>Las tablas vacías han sido creadas con éxito.</p>";
            } else {
                $this->mensajeCrearTabla="<p>ERROR en la creación de las tablas. " . mysqli_error($this->db) . "</p>";
            } 
            $this->db->close();           
        }
    }

    // Creación e inicialización de las tablas
    public function initTablas(){
            $this->reiniciarMensajes();
            $this->crearTablas();
            $this->crearBD();
            $this->db->select_db("cine");

            // Insertar directores de ejemplo
            $this->db->query(    "INSERT INTO director (nombre_director, fecha_nacimiento, lugar_nacimiento, corriente) 
                VALUES ('Stanley Kubrick','1928-07-26','Nueva York, EEUU','Siglo XX: bélico, thriller, terror')"   );
            $this->db->query(    "INSERT INTO director (nombre_director, fecha_nacimiento, lugar_nacimiento, corriente) 
                VALUES ('Steven Spielberg','1946-12-18','Ohio, EEUU','Siglo XX/XXI: aventura, sci-fi')"   );
            $this->db->query(    "INSERT INTO director (nombre_director, fecha_nacimiento, lugar_nacimiento, corriente) 
                VALUES ('David Fincher','1962-08-28','Colorado, EEUU','2000s: thriller psicológico, crimen')"   );

            // Insertar actores de ejemplo
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
                VALUES ('Tom Cruise','Thomas Cruise Mapother IV','1962-07-03','Nueva York, EEUU')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
                VALUES ('Brad Pitt','William Bradley Pitt','1963-12-18','Oklahoma, EEUU')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
                VALUES ('Sam Neill','Nigel John Dermot /Sam/ Neill','1947-09-14','Irlanda del Norte')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
                VALUES ('Morgan Freeman','Morgan Freeman','1937-06-01','Tennessee, EEUU')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
                VALUES ('Nicole Kidman','Nicole Mary Kidman','1967-06-20','Hawaii, EEUU')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
            VALUES ('Laura Dern','Laura Elizabeth Dern','1967-02-10','California, EEUU')"   );
            $this->db->query(    "INSERT INTO actor (nombre_actor, nombre_real, fecha_nacimiento, lugar_nacimiento) 
            VALUES ('Gwyneth Paltrow','Gwyneth Kate Paltrow','1972-09-27','California, EEUU')"   );

            // Insertar premios de ejemplo
            $this->db->query(    "INSERT INTO premio (cod_premio,nombre_premio, categoria)
            VALUES ('OMVFX','Oscar','Mejores efectos especiales')"   );
            $this->db->query(    "INSERT INTO premio (cod_premio,nombre_premio, categoria)
            VALUES ('OMGuion','Oscar','Mejor guion')"   );
            $this->db->query(    "INSERT INTO premio (cod_premio,nombre_premio, categoria)
            VALUES ('GOMPelicula','Globo de Oro','Mejor película')"   );

            // Insertar productoras de ejemplo
            $this->db->query(    "INSERT INTO productora (nombre_productora, sede, año_creacion) 
                VALUES ('Warner Bros','Burbank, California, EEUU', 1923)"   );
            $this->db->query(    "INSERT INTO productora (nombre_productora, sede, año_creacion) 
            VALUES ('Warner Bros','Los Angeles, California, EEUU', 1935)"   );
            $this->db->query(    "INSERT INTO productora (nombre_productora, sede, año_creacion) 
            VALUES ('New Line Cinema','Burbank, California, EEUU', 1967)"   );
            $this->db->query(    "INSERT INTO productora (nombre_productora, sede, año_creacion) 
            VALUES ('Universal Pictures','Los Angeles, California, EEUU', 1912)"   );

            // Insertar películas de ejemplo
            $this->db->query(    "INSERT INTO pelicula (nombre_pelicula, nombre_actor, nombre_productora, 
            nombre_director, cod_premio, año, valoracion, duracion, opinion,genero)
                 VALUES ('Eyes Wide Shut','Tom Cruise','Warner Bros','Stanley Kubrick',null,1999,5,159,'Buenísima y extraña','Thriller psicológico')"   );
            $this->db->query(    "INSERT INTO pelicula (nombre_pelicula, nombre_actor, nombre_productora, 
            nombre_director, cod_premio, año, valoracion, duracion, opinion, genero)
                 VALUES ('Se7en','Brad Pitt','New Line Cinema','David Fincher',null,1995,4,127,'Brutal','Thriller, crimen')"   );
            $this->db->query(    "INSERT INTO pelicula (nombre_pelicula, nombre_actor, nombre_productora, 
            nombre_director, cod_premio, año, valoracion, duracion, opinion, genero)
                 VALUES ('Jurassic Park','Sam Neill','Universal Pictures','Steven Spielberg','OMVFX',1993,3.5,121,'Un clásico','Aventura')"   );

            $this->mensajeCrearTabla="<p>Las tablas han sido inicializadas con los datos de ejemplo.</p>";
            $this->db->close();           
        }


    // Devuelve el número actual de filas en las tablas
    public function getNumeroActores(){
        $this->crearBD();
        $this->db->select_db("cine");

        $count = ($this->db->query($this->contarActores))->num_rows;
        $this->db->close();
        return $count;
    }
    public function getNumeroProductoras(){
        $this->crearBD();
        $this->db->select_db("cine");

        $count = ($this->db->query($this->contarProductoras))->num_rows;
        $this->db->close();
        return $count;
    }
    public function getNumeroDirectores(){
        $this->crearBD();
        $this->db->select_db("cine");

        $count = ($this->db->query($this->contarDirectores))->num_rows;
        $this->db->close();
        return $count;
    }
    public function getNumeroPremios(){
        $this->crearBD();
        $this->db->select_db("cine");

        $count = ($this->db->query($this->contarPremios))->num_rows;
        $this->db->close();
        return $count;
    }
    public function getNumeroPeliculas(){
        $this->crearBD();
        $this->db->select_db("cine");

        $count = ($this->db->query($this->contarPeliculas))->num_rows;
        $this->db->close();
        return $count;
    }

        // Devuelve el número actual de filas en la tabla de pruebas
    public function existeEnBD($dni){
        $this->crearBD();
        $this->db->select_db("usabilidad");

        $consulta = $this->verSiExiste . $dni . "'";
        $count = ($this->db->query($consulta))->num_rows;

        $this->db->close();
        return $count != 0;
    }


    // Insertar filas en la tabla
    public function insertarActor(){
        $antes = $this->getNumeroActores();
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->insertarActor);


        // Añadir parámetros
        $query->bind_param('ssss', 
        $_POST["nombre_actor"], $_POST["nombre_real_actor"],$_POST["fecha_actor"],$_POST["lugar_actor"]);
        
        $query->execute();
        $despues = $this->getNumeroActores();

        if ($antes<$despues)
            $this->mensajeInsertarActor = "<p>Fila insertada con éxito.</p>";
        else
            $this->mensajeInsertarActor = "<p>La fila no ha podido insertarse por restricciones de integridad (el nombre del actor ha de ser único)</p>";
        $query->close();
    }
    public function insertarProductora(){
        $antes = $this->getNumeroProductoras();
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->insertarProductora);


        // Añadir parámetros
        $query->bind_param('ssi', 
        $_POST["nombre_productora"], $_POST["sede"],$_POST["creacion"]);
        
        $query->execute();
        $despues = $this->getNumeroProductoras();

        if ($antes<$despues)
            $this->mensajeInsertarProductora = "<p>Fila insertada con éxito.</p>";
        else
            $this->mensajeInsertarProductora = "<p>La fila no ha podido insertarse por restricciones de integridad (el nombre de la productora ha de ser único)</p>";
        $query->close();
    }
    public function insertarDirector(){
        $antes = $this->getNumeroDirectores();
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->insertarDirector);


        // Añadir parámetros
        $query->bind_param('ssss', 
        $_POST["nombre_director"], $_POST["fecha_director"], $_POST["lugar_director"], $_POST["corriente"]);
        
        $query->execute();
        $despues = $this->getNumeroDirectores();

        if ($antes<$despues)
            $this->mensajeInsertarDirector = "<p>Fila insertada con éxito.</p>";
        else
            $this->mensajeInsertarDirector = "<p>La fila no ha podido insertarse por restricciones de integridad (el nombre del director ha de ser único)</p>";
        $query->close();
    }
    public function insertarPremio(){
        $antes = $this->getNumeroPremios();
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->insertarPremio);

        // Añadir parámetros
        $query->bind_param('sss', 
        $_POST["cod_premio"],$_POST["nombre_premio"], $_POST["categoria"]);
        
        $query->execute();
        $despues = $this->getNumeroPremios();

        if ($antes<$despues)
            $this->mensajeInsertarPremio = "<p>Fila insertada con éxito.</p>";
        else
            $this->mensajeInsertarPremio = "<p>La fila no ha podido insertarse por restricciones de integridad (la combinación de nombre y categoría han de ser únicas)</p>";
        $query->close();
    }
    public function insertarPelicula(){
        $antes = $this->getNumeroPeliculas();
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");


        // Caso de que alguno de estos esté vacío
        if ($_POST["nombre_actorPeli"] === "---"
            || $_POST["nombre_productoraPeli"] === "---"
            || $_POST["nombre_directorPeli"] === "---"){
                $this->mensajeInsertarPelicula = "<p>No puede crearse una película si no se conoce actor, productora o director.</p>";
                return;
        }

        // Ningún premio relacionado
        if ($_POST["nombre_premioPeli"] === "---"){
            $premio = null;
        } else {
            $nombre_categoria = explode("-",$_POST["nombre_premioPeli"]);
            $nombre = $nombre_categoria[0];
            $categoria = $nombre_categoria[1];
            $premio = $this->buscarPremio($nombre,$categoria);
        }

        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->insertarPelicula);
        $query->bind_param('sssssiiiss', 
        $_POST["nombre_pelicula"], $_POST["nombre_actorPeli"],$_POST["nombre_productoraPeli"],$_POST["nombre_directorPeli"],$premio,
        $_POST["año"], $_POST["valoracion"], $_POST["duracion"], $_POST["opinion"],$_POST["genero"]);
        $query->execute();
        $despues = $this->getNumeroPeliculas();

        if ($antes<$despues)
            $this->mensajeInsertarPelicula = "<p>Fila insertada con éxito.</p>";
        else
            $this->mensajeInsertarPelicula = "<p>La fila no ha podido insertarse por restricciones de integridad (el nombre de la película ha de ser único)</p>";
        $query->close();
    }

    // Opciones para loguear peliculas
    public function getOpcionActores(){

        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->contarActores);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();

        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_actor"];
                    echo "<option value='" . $nombre . "'>". $nombre . "</option>";             
                } catch (Exception $e) {
                    return;
                }
            }
    }

    public function getOpcionDirectores(){

        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->contarDirectores);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();

        if ($result->num_rows === 0){
            echo "<p>No hay directores aún en la BD.</p>";
        }
        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_director"];
                    echo "<option value='" . $nombre . "'>". $nombre . "</option>";             
                } catch (Exception $e) {
                    return;
                }
            }
    }

    public function getOpcionPeliculas(){

        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->contarPeliculas);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();

        if ($result->num_rows === 0){
            echo "<p>No hay directores aún en la BD.</p>";
        }
        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_pelicula"];
                    echo "<option value='" . $nombre . "'>". $nombre . "</option>";             
                } catch (Exception $e) {
                    return;
                }
            }
    }

    public function getOpcionProductoras(){

        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->contarProductoras);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();

        if ($result->num_rows === 0){
            echo "<p>No hay productoras aún en la BD.</p>";
        }
        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_productora"];
                    echo "<option value='" . $nombre . "'>". $nombre . "</option>";             
                } catch (Exception $e) {
                    return;
                }
            }
    }


    public function getOpcionPremios(){

        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->contarPremios);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();

        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_premio"];
                    $categoria = $fila["categoria"];
                    echo "<option value='" . $nombre . "-" . $categoria . "'>". $nombre . " a " . $categoria . "</option>";             
                } catch (Exception $e) {
                    return;
                }
            }
    }

    // Coger código del premio
    public function buscarPremio($nombre,$categoria){
        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->buscarCodPremio);
        $query->bind_param('ss',$nombre,$categoria);
        $query->execute();

        // Coger el resultado
        $resultado = $query->get_result();
        // Mostrar los resultados
        if ($resultado->fetch_assoc()!=NULL){
            // Imprimir si existen
            $resultado->data_seek(0); // Solo tendrá un resultado
            $fila = $resultado->fetch_assoc();
            return $fila["cod_premio"];
        } return null;
    }


    // Muestra en pantalla datos sobre los participantes de la película
    public function mostrarDirector($director){
                // Preparar la consulta y ejecutarla
                $this->crearBD();
                $this->db->select_db("cine");
                $query = $this->db->prepare($this->buscarDirector);
                $query->bind_param('s',$director);
                $query->execute();
        
                // Coger el resultado
                $resultado = $query->get_result();
                // Mostrar los resultados
                if ($resultado->fetch_assoc()!=NULL){
                    // Imprimir si existen
                    $resultado->data_seek(0); // Solo tendrá un resultado
                    $fila = $resultado->fetch_assoc();
                    $this->mensajeBuscarDatos .= "<h6> Director/a </h6>";
                    $this->mensajeBuscarDatos .= "<ul>"
                    . "<li> Nombre: " . $fila["nombre_director"] . "</li>"
                    . "<li> Fecha de nacimiento: " . $fila["fecha_nacimiento"] . "</li>"
                    . "<li> Lugar de nacimiento: " . $fila["lugar_nacimiento"] . "</li>"
                    . "<li> Corriente cinematográfica: " . $fila["corriente"] . "</li></ul>";
                }  
    }
    public function mostrarActor($nombre){
                // Preparar la consulta y ejecutarla
                $this->crearBD();
                $this->db->select_db("cine");
                $query = $this->db->prepare($this->buscarActor);
                $query->bind_param('s',$nombre);
                $query->execute();
        
                // Coger el resultado
                $resultado = $query->get_result();
                // Mostrar los resultados
                if ($resultado->fetch_assoc()!=NULL){
                    // Imprimir si existen
                    $resultado->data_seek(0); // Solo tendrá un resultado
                    $fila = $resultado->fetch_assoc();

                    $this->mensajeBuscarDatos .= "<h6> Actor protagonista </h6>";
                    $this->mensajeBuscarDatos .= "<ul>"
                    . "<li> Nombre artístico: " . $fila["nombre_actor"] . "</li>"
                    . "<li> Nombre real: " . $fila["nombre_real"] . "</li>"
                    . "<li> Fecha de nacimiento: " . $fila["fecha_nacimiento"] . "</li>"
                    . "<li> Fecha de nacimiento: " . $fila["lugar_nacimiento"] . "</li>" 
                    . "</ul>";
                }  
    }
    public function mostrarProductora($nombre){
        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->buscarProductora);
        $query->bind_param('s',$nombre);
        $query->execute();

        // Coger el resultado
        $resultado = $query->get_result();
        // Mostrar los resultados
        if ($resultado->fetch_assoc()!=NULL){
            // Imprimir si existen
            $resultado->data_seek(0); // Solo tendrá un resultado
            $fila = $resultado->fetch_assoc();

            $this->mensajeBuscarDatos .= "<h6> Producida por: </h6>";
            $this->mensajeBuscarDatos .= "<ul>"
            . "<li> Compañía cinematográfica: " . $fila["nombre_productora"] . "</li>"
            . "<li> Sede: " . $fila["sede"] . "</li>"
            . "<li> Fecha de fundación: " . $fila["año_creacion"] . "</li>"
            . "</ul>";
        }  
    }
    public function mostrarPremio($nombre){
        // Preparar la consulta y ejecutarla
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->buscarPremio);
        $query->bind_param('s',$nombre);
        $query->execute();

        // Coger el resultado
        $resultado = $query->get_result();
        $this->mensajeBuscarDatos .= "<h5> Galardonada con: </h5>";

        // Mostrar los resultados
        if ($resultado->fetch_assoc()!=NULL){
            // Imprimir si existen
            $resultado->data_seek(0); // Solo tendrá un resultado
            $fila = $resultado->fetch_assoc();

            $this->mensajeBuscarDatos .= "<p> " . $fila["nombre_premio"] . " a " . $fila["categoria"] . "</p>";
        } else {
            $this->mensajeBuscarDatos .= "<p> Ningún premio.</p>";

        }
    }

    public function buscarDatos(){

        // Preparar la consulta y ejecutarl
        $nombre = $_POST["nombreBuscar"];
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->buscarDatos);
        $query->bind_param('s',$nombre);
        $query->execute();

        // Coger el resultado
        $resultado = $query->get_result();
        // Mostrar los resultados
        if ($resultado->fetch_assoc()!=NULL){
            // Imprimir si existen
            $resultado->data_seek(0); // Solo tendrá un resultado
            $fila = $resultado->fetch_assoc();

            $this->mensajeBuscarDatos = "<h4> " . $nombre . " </h4>";
            $this->mensajeBuscarDatos .= "<ul>"
            . "<li> Género: " . $fila["genero"] . "</li>"
            . "<li> Año de estreno: " . $fila["año"] . "</li>"
            . "<li> Duración: " . $fila["duracion"] . "' </li>"
            . "</ul>"
            ;
            $this->mensajeBuscarDatos .= "<h5> Valoración personal </h5>"
                . "<ul><li> Puntuación: " . $fila["valoracion"] . "/5 </li>"
                . "<li> Opinión: " . $fila["opinion"] . "</li></ul>";
            $this->mensajeBuscarDatos .= "<h5> Cast & crew </h5>";

            $director = $fila["nombre_director"];
            $this->mostrarDirector($director);

            $actor = $fila["nombre_actor"];
            $this->mostrarActor($actor);

            $productora = $fila["nombre_productora"];
            $this->mostrarProductora($productora);

            $cod_premio = $fila["cod_premio"];
            $this->mostrarPremio($cod_premio);

        } else {
            $this->mensajeBuscarDatos = "<p>No ha seleccionado ninguna película. </p>";
        }
    }

    public function buscarPorDirector(){

        // Preparar la consulta y ejecutarl
        $nombre = $_POST["buscarPorDirector"];
        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->buscarDatosPorDirector);
        $query->bind_param('s',$nombre);
        $query->execute();

        // Coger el resultado
        $result = $query->get_result();
        $this->mensajeBuscarDirector = "<p> Número de películas digiridas: " . $result->num_rows . "</p>";

        // Mostrar los resultados
        while ($fila = $result->fetch_array(MYSQLI_ASSOC)) {
                try {
                    $nombre = $fila["nombre_pelicula"];
                    $actor = $fila["nombre_actor"];
                    $productora = $fila["nombre_productora"];
                    $año = $fila["año"];
                    $genero = $fila["genero"];

                    $this->mensajeBuscarDirector = "<h4> " . $nombre . "</h4>";
                    $this->mensajeBuscarDirector .= "<ul><li>Actor protagonista: " . $actor . "</li>"
                    . "<li>Producida por: " . $productora . "</li>"
                    . "<li>Estreno: " . $año . "</li>"
                    . "<li>Género: " . $genero . "</li></ul>";
                } catch (Exception $e) {
                    return;
                }
            }
    }


    public function borrarDatos(){

        // Preparar la consulta y ejecutarla
        $peli = $_POST["borrarPeli"];

        $this->reiniciarMensajes();
        $this->crearBD();
        $this->db->select_db("cine");
        $query = $this->db->prepare($this->borrarDatos);
        $query->bind_param('s',$peli);
        $query->execute();
        $this->mensajeBorrarDatos = "<p>La película " . $peli . " ha sido eliminada con éxito.<p>";
    }


}

// Definición de una nueva sesión
if (!isset($_SESSION['bdcine'])){
    $bd = new BaseDatos();
    $_SESSION['bdcine'] = $bd;        
}
// Interacción con todos los botones
if (count($_POST)>0)
{
    $bd = $_SESSION['bdcine'];

    if (isset($_POST['crearBDCine'])) $bd->crearBD();
    if (isset($_POST['crearTablaCine'])) $bd->crearTablas();
    if (isset($_POST['inicializar'])) $bd->initTablas();
    if (isset($_POST['insertarActor'])) $bd->insertarActor();
    if (isset($_POST['insertarProductora'])) $bd->insertarProductora();
    if (isset($_POST['insertarDirector'])) $bd->insertarDirector();
    if (isset($_POST['insertarPremio'])) $bd->insertarPremio();
    if (isset($_POST['insertarPelicula'])) $bd->insertarPelicula();
    if (isset($_POST['borrar'])) $bd->borrarDatos();
    if (isset($_POST['buscar'])) $bd->buscarDatos();
    if (isset($_POST['buscarDirector'])) $bd->buscarPorDirector();

    $_SESSION['bdcine'] = $bd;
}

?>