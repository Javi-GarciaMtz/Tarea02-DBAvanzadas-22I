<?php

if(isset($_POST['estadoConsulta'])){

    $conexión = oci_connect('system', 'admin', 'localhost/XE');
    if (!$conexión) {
        $e = oci_error();
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
    }

    $estadoC = $_POST['estadoConsulta'];

    $stid = oci_parse($conexión, 'begin :r := OBTEN_ESTADOS(:p); end;');
    oci_bind_by_name($stid, ':p', $estadoC);
    oci_bind_by_name($stid, ':r', $r, 40);
    oci_execute($stid);

    $data = array(
        'success' => 1,
        'code' => 200,
        'status' => 'success',
        'estadoConsulta' => $r
    );

    echo json_encode($data);

}elseif(isset($_POST['opcionModificar'])) {

    if($_POST['opcionModificar'] == 'cambiarNombre') {
        $conn = oci_connect("system", "admin", "localhost/XE");
        $query = "BEGIN MOD_NOMBRE('".$_POST['nuevoNombre']."', '".$_POST['nombre']."', '".$_POST['estado']."'); END;";

        $stid = oci_parse($conn, $query);
        $r = oci_execute($stid);

        if($r) {
            $data = array(
                'success' => 1,
                'code' => 200,
                'status' => 'success',
                'statusMod' => $r
            );
        } else {
            $data = array(
                'success' => 0,
                'code' => 500,
                'status' => 'failed',
                'statusMod' => $r
            );
        }

        echo json_encode($data);

    } elseif($_POST['opcionModificar'] == 'cambiarCalificacion') {

        $conexión = oci_connect('system', 'admin', 'localhost/XE');
        if (!$conexión) {
            $e = oci_error();
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        $p = $_POST['nuevoCalificacion'];
        $s = $_POST['nombre'];
        $w = $_POST['estado'];

        $stid = oci_parse($conexión, 'begin :r := MOD_CALIFICACION(:p, :s, :w); end;');
        oci_bind_by_name($stid, ':p', $p);
        oci_bind_by_name($stid, ':s', $s);
        oci_bind_by_name($stid, ':w', $w);

        oci_bind_by_name($stid, ':r', $r, 40);

        oci_execute($stid);


        if($r == '1') {
            $data = array(
                'success' => 1,
                'code' => 200,
                'status' => 'success',
                'statusMod' => $r
            );
        } else {
            $data = array(
                'success' => 0,
                'code' => 500,
                'status' => 'failed',
                'statusMod' => $r
            );
        }

        oci_free_statement($stid);
        oci_close($conexión);

        echo json_encode($data);

    } elseif($_POST['opcionModificar'] == 'eliminaUbicacion'){
        $conn = oci_connect("system", "admin", "localhost/XE");
        $query = "BEGIN ELIMINA_UBI('".$_POST['nombre']."', '".$_POST['estado']."'); END;";

        $stid = oci_parse($conn, $query);
        $r = oci_execute($stid);

        if($r) {
            $data = array(
                'success' => 1,
                'code' => 200,
                'status' => 'success',
                'statusEliminacion' => $r
            );
        } else {
            $data = array(
                'success' => 0,
                'code' => 500,
                'status' => 'failed',
                'statusEliminacion' => $r
            );
        }

        echo json_encode($data);
    }


} elseif(isset($_POST['consultarUbicaciones'])) {

    // $data = array(true);
    // echo json_encode($data);

    $conn = oci_connect("system", "admin", "localhost/XE");
    $query = 'SELECT * FROM ubicacion';

    $stid = oci_parse($conn, $query);
    $r = oci_execute($stid);

    oci_fetch_all($stid, $res);

    $data = array(
        'success' => 1,
        'code' => 200,
        'status' => 'success',
        'data' => $res
    );

    echo json_encode($data);

} elseif (
    isset($_POST['nombre']) &&
    isset($_POST['estado']) &&
    isset($_POST['ubicacionExacta']) &&
    isset($_POST['calificacion']) &&
    isset($_POST['descripcion'])
) {
    // $array = array($_POST['nombre'], $_POST['estado'], $_POST['ubicacionExacta'], $_POST['calificacion'],$_POST['descripcion']);
    //

    // Create connection to Oracle
    $conn = oci_connect("system", "admin", "localhost/XE");
    $query = "INSERT INTO ubicacion VALUES('".$_POST['nombre']."', '".$_POST['estado']."', '".$_POST['ubicacionExacta']."', ".$_POST['calificacion'].", '".$_POST['descripcion']."')";
    $stid = oci_parse($conn, $query);
    $r = oci_execute($stid);

    if($r) {
        $data = array(
            'success' => 1,
            'code' => 200,
            'status' => 'success',
            'statusInsert' => $r
        );
    } else {
        $data = array(
            'success' => 0,
            'code' => 500,
            'status' => 'failed',
            'statusInsert' => $r
        );
    }
    echo json_encode($data);

}

?>