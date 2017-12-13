<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($estudiantes);
      print_r($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellido_p');
    $apellidom = $request->getParam('apellido_m}');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = 	"INSERT INTO estudiante (No_control, nombre, apellido_p, apellido_m, semestre, carrera_clave) VALUES (:No_control, :nombre_estudiante, :apellido_p_estudiante, :apellido_m_estudiante, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_p_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_p_estudiante');
    $apellidom = $request->getParam('apellido_m_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                No_control              = :No_control,
                nombre       = :nombre_estudiante,
                apellido_p   = :apellido_p_estudiante,
                apellido_m   = :apellido_m_estudiante,
                semestre                = :semestre,
                carrera_clave           = :carrera_clave
            WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_p_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_m_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');

    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//CARRERA
// Obtener todas las carreras

$app->get('/api/carrera', function(Request $request, Response $response){
	//echo "materias";
	$sql = "select * from carrera";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($carrera);
      print_r($carrera);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Agregar una carrera
$app->post('/api/carrera/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "INSERT INTO carrera (clave, nombre) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':nombre',$nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/carrera/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = "UPDATE carrera SET
                clave        = :clave,
                nombre       = :nombre

            WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre',  $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "carrera actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Borrar carrera
$app->delete('/api/carrera/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM carrera WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "carrera eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//DEPARTAMENTO

// Obtener todos los departamentos

$app->get('/api/departamento', function(Request $request, Response $response){
	//echo "departamento";
	$sql = "select * from departamento";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($departamento);
      print_r($departamento);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




// Agregar un departamento
$app->post('/api/departamento/add', function(Request $request, Response $response){
    $ClaveDepa = $request->getParam('ClaveDepa');
    $nombre = $request->getParam('nombre');
		$trabajador_rfc = $request->getParam('trabajador_rfc');


    $sql = "INSERT INTO departamento (ClaveDepa, nombre, trabajador_rfc) VALUES (:ClaveDepa, :nombre, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ClaveDepa', $ClaveDepa);
        $stmt->bindParam(':nombre',$nombre);
				$stmt->bindParam(':trabajador_rfc',$trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





// Actualizar departamento
$app->put('/api/departamento/update/{ClaveDepa}', function(Request $request, Response $response){
    $ClaveDepa = $request->getParam('ClaveDepa');
    $nombre = $request->getParam('nombre');
		$trabajador_rfc=$request->getParam('trabajador_rfc');


    $sql = "UPDATE departamento SET
                ClaveDepa        = :ClaveDepa,
                nombre       = :nombre,
								trabajador_rfc = :trabajador_rfc

            WHERE ClaveDepa = '".$ClaveDepa."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ClaveDepa',   $ClaveDepa);
        $stmt->bindParam(':nombre',  $nombre);
				$stmt->bindParam(':trabajador_rfc',  $trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});





// Borrar departamento
$app->delete('/api/departamento/delete/{ClaveDepa}', function(Request $request, Response $response){
    $ClaveDepa = $request->getAttribute('ClaveDepa');

    $sql = "DELETE FROM departamento WHERE ClaveDepa = '".$ClaveDepa."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});




//instituto

$app->get('/api/instituto', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instituto = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un insttuto por clave
$app->get('/api/instituto/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "SELECT * FROM instituto WHERE clave = '$clave'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $clave = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($clave);
				//print_r($clave);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un instituto
$app->post('/api/instituto/add', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');


    $sql = 	"INSERT INTO instituto (clave, nombre) VALUES (:clave, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',      $clave);
        $stmt->bindParam(':nombre',     $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar instituto
$app->put('/api/instituto/update/{clave}', function(Request $request, Response $response){
    $clave = $request->getParam('clave');
    $nombre = $request->getParam('nombre');



    $sql = "UPDATE instituto SET
                clave        = :clave,
                nombre       = :nombre


            WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave',   $clave);
        $stmt->bindParam(':nombre',  $nombre);



        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar instituto
$app->delete('/api/instituto/delete/{clave}', function(Request $request, Response $response){
    $clave = $request->getAttribute('clave');

    $sql = "DELETE FROM instituto WHERE clave = '".$clave."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



//act_complementaria

$app->get('/api/act_complementaria', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from act_complementaria";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($act_complementaria);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});



// Obtener una complementaria por clave
$app->get('/api/act_complementaria/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "SELECT * FROM act_complementaria WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act_complementaria);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar una act_complementaria
$app->post('/api/act_complementaria/add', function(Request $request, Response $response){
    $claveact = $request->getParam('clave_act');
    $nombre = $request->getParam('nombre');


    $sql = 	"INSERT INTO act_complementaria (clave_act, nombre) VALUES (:clave_act, :nombre)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',  $claveact);
        $stmt->bindParam(':nombre',     $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "complementaria agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar act_complementaria
$app->put('/api/act_complementaria/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre = $request->getParam('nombre');

    $sql = "UPDATE act_complementaria SET
                clave_act              = :clave_act,
                nombre       = :nombre
            WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',      $clave_act);
        $stmt->bindParam(':nombre',         $nombre);


        $stmt->execute();

        echo '{"notice": {"text": "complementaria actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Borrar act_complementaria
$app->delete('/api/act_complementaria/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM act_complementaria WHERE clave_act = $clave_act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "act_complementaria eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//instructor

$app->get('/api/instructor', function(Request $request, Response $response){
    //echo "institu";
    $sql = "select * from instructor";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($instructor);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener una complementaria por clave
$app->get('/api/instructor/{rfc}', function(Request $request, Response $response){
    $rfc = $request->getAttribute('rfc');

    $sql = "SELECT * FROM instructor WHERE rfc = '".$rfc."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($instructor);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Agregar un instructor
$app->post('/api/instructor/add', function(Request $request, Response $response){
    $rfc = $request->getParam('rfc');
    $nombre = $request->getParam('nombre');
		$apellido_p = $request->getParam('apellido_p');
		$apellido_m = $request->getParam('apellido_m');
		$act_complementaria_clave_act = $request->getParam('act_complementaria_clave_act');


    $sql = 	"INSERT INTO instructor (rfc, nombre, apellido_p, apellido_m, act_complementaria_clave_act) VALUES (:rfc, :nombre, :apellido_p, :apellido_m, :act_complementaria_clave_act)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc',  $rfc);
        $stmt->bindParam(':nombre',     $nombre);
				$stmt->bindParam(':apellido_p',     $apellido_p);
				$stmt->bindParam(':apellido_m',     $apellido_m);
				$stmt->bindParam(':act_complementaria_clave_act',     $act_complementaria_clave_act);


        $stmt->execute();

        echo '{"notice": {"text": "instructor agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
