<?php
include_once 'conexion.php';
$statusMsg = '';
if(isset($_POST['importSubmit'])){
    
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            fgetcsv($csvFile);
            
            while(($line = fgetcsv($csvFile)) !== FALSE){
                
                $folios_banco   = $line[0];
                $fecha_pago = $line[1];
               
                
                $prevQuery = "SELECT folios_banco FROM folios_banco WHERE folios_banco = '".$folios_banco."'";
                $prevResult = $conexion->query($prevQuery);
                
                if($prevResult->num_rows > 0){
                    $conexion->query("UPDATE folios_banco SET fecha_pago = '".$fecha_pago."' WHERE folios_banco = '".$folios_banco."'");
                    
                }elseif ($prevResult->num_rows > 0) {
                    $statusMsg = 'Folio ya registrado: '.$folios_banco;
                }else{
                    $conexion->query("INSERT INTO folios_banco (folios_banco, fecha_pago) VALUES ('".$folios_banco."', '".$fecha_pago."')");
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
