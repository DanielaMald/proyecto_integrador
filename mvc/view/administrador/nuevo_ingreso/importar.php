<?php

include_once 'conexion.php';
$statusMsg = '';

if (isset($_POST['importSubmit'])) {
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
        
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            

            $expectedColumns = 6; 
            $header = fgetcsv($csvFile);
            
            if (count($header) == $expectedColumns) {
                while (($line = fgetcsv($csvFile)) !== FALSE) {
                    // Get row data
                    $folio_estudiante   = $line[0];
                    $nombre  = $line[1];
                    $apellido1 = $line[2];
                    $apellido2 = $line[3];
                    $periodo = $line[4];
                    $correo = $line[5];
                    
                    $prevQuery = "SELECT folio_estudiante FROM estudiantes_aceptados WHERE folio_estudiante = '".$folio_estudiante."'";
                    $prevResult = $conn->query($prevQuery);
                    if($prevResult->num_rows > 0){
                        $conn->query("UPDATE estudiantes_aceptados SET nombre = '".$nombre."', apellido1 = '".$apellido1."', apellido2 = '".$apellido2."', periodo = '".$periodo."', correo = '".$correo."' WHERE folio_estudiante = '".$folio_estudiante."'");
                    }elseif ($prevResult->num_rows > 0) {
                        $statusMsg = 'Folio ya registrado: '.$folio_estudiante;
                    } else {
                        $conn->query("INSERT INTO estudiantes_aceptados (folio_estudiante, nombre, apellido1, apellido2, periodo, correo) VALUES ('".$folio_estudiante."', '".$nombre."', '".$apellido1."', '".$apellido2."', '".$periodo."', '".$correo."')");
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
}

// Redirect to the listing page
header("Location: index.php".$qstring);
?>