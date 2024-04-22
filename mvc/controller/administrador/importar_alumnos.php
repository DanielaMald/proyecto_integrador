<?php
include '../../model/administrador.php';

$statusMsg = '';

if(isset($_POST['importSubmit'])){
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $modelo = new Administrador();
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            
            while(($line = fgetcsv($csvFile)) !== FALSE){
                $matricula = $line[0];
                $nombre = $line[1];
                $apellido1 = $line[2];
                $apellido2 = $line[3];
                $fecha_nacimiento = $line[4];
                $residencia = $line[5];
                $correo = $line[6];
                if($modelo->verificarMatricula($matricula)){
                    $modelo->actualizarMatricula($matricula, $nombre);
                } else {
                    $modelo->insertarMatricula($matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $residencia, $correo, null);

                }
            }
            
            fclose($csvFile);
            $qstring = '?status=succ';
        } else {
            $qstring = '?status=invalid_columns';
        }
    } else {
        $qstring = '?status=err';
    }
} else {
    $qstring = '?status=invalid_file';
}

header("Location: index.php".$qstring);
?>
