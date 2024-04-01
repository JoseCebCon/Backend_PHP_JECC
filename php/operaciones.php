<?php
include('connection.php');

//Leemos raw POST data del request body
$data = json_decode(file_get_contents('php://input'), true);

//Verficamos la accion
if(isset($_GET['accion'])) {
    $accion=$_GET['accion'];

    //Leer datos de la tabla de usuarios
    if($accion== 'leer'){
        $sql = "select * from alumnos where 1";
        $result = $db->query($sql);

        if($result ->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $item['id']= $fila['id'];
                $item['apellido_paterno']= $fila['apellido_paterno'];
                $item['apellido_materno']= $fila['apellido_materno'];
                $item['nombre']= $fila['nombre'];
                $arrAlumnos[] = $item;
            }
            $response["status"] = "ok";
            $response["mensaje"] = $arrAlumnos;
        }
        else{
            $response["status"] = "Error";
            $response["mensaje"] = "No hay alumnos registrados";
        }

        header('content-type: application/json');
        echo json_encode($response);
    }

}

//Si yo paso los datos como JSON a traves del body
if(isset($data)){
    //Obtengo la accion
    $data = json_decode(file_get_contents('php://input'), true);
    $accion = $data["accion"];

    //Verifico el tipo de accion
    if($accion =='insertar'){
        //Obtener los demas datos del body
        $apellido_paterno = $data["apellido_paterno"];
        $apellido_materno = $data["apellido_paterno"];
        $nombre = $data["nombre"];

        $qry = "INSERT INTO alumnos (apellido_paterno, apellido_materno, nombre) values ('$apellido_paterno','$apellido_materno','$nombre')";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se creo correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se creo correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'modificar'){
        $id = $data["id"];
        $apellido_paterno = $data["apellido_paterno"];
        $apellido_materno = $data["apellido_paterno"];
        $nombre = $data["nombre"];

        $qry = "UPDATE alumnos set apellido_paterno = '$apellido_paterno', apellido_materno = '$apellido_materno', nombre = '$nombre' where id = '$id'";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se modifico correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se modifico correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($accion == 'borrar'){
        $id = $data["id"];

        $qry = "delete from alumnos where id = '$id'";
        
        if($db->query($qry)){
            $response["status"] = 'OK';
            $response["mensaje"] = 'El registro se elimino correctamente';
        }
        else{
            $response["status"] = 'ERROR';
            $response["mensaje"] = 'El registro no se elimino correctamente';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
