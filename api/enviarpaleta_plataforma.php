  <?php

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
  

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
date_default_timezone_set('America/Lima');
// session_start();
stream_context_set_default([
	'ssl' => [
		'verify_peer' => false,
		'verify_peer_name' => false
	]
]);
$json = file_get_contents("php://input");
$data = json_decode($json, true);
//$data = $_POST;
/*$tipo = "P-30-067-";
$tags = "000000000000040100000773-000000000000040100000826-000000000000040100000836-000000000000030101001526";
$mac= "[RFID->DC:0D:30:A6:24:A3]";	
$fecha = "2020-12-18 16:44:57";*/
print_r($data);
$tipo = $data['tipo'];
$tags = $data['tags'];
//$tags = explode("-",$tags);
$mac = $data['mac'];
$fecha = $data['fecha'];
$fechaTest = date("Y-m-d H:i:s");

$tags = implode('-',array_unique(explode('-', $tags)));
$post = array(
	'tags' => $tags,
	'tipo' => $tipo,		
	'mac' => $mac,
	'fecha' => $fecha		
);
/******************/
$servername = "162.144.13.149";
$username = "solutsgg_kannia";
$password = "FVEfgBtJEo2]";
$dbname = "solutsgg_kannia";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn1 = mysqli_connect($servername, $username, $password, $dbname);

//$sql = "INSERT INTO lecturas(identificador, mac, data, timestamp) VALUES ('".$tipo."', '".$mac."', '".$tags."', '".$fechaTest."')";
//$sql = "INSERT INTO clouddata(data1, data2, data3, fecha) VALUES ('hola', 'soy', 'christian', 'cajusol')";
    $tag = explode("-",$tags);
    foreach($tag as $indice => $chip){
        $sql = "INSERT INTO tbl_movimientos(identificador, mac, codigo_rfid, fecha) VALUES ('".$tipo."', '".$mac."', '".$tag[$indice]."', '".$fechaTest."')";
           $sql1 = "INSERT INTO tbl_vinculacion_masiva(identificador, mac, codigo_rfid, fecha) VALUES ('".$tipo."', '".$mac."', '".$tag[$indice]."', '".$fechaTest."')";
        echo $sql;
        if (mysqli_query($conn, $sql) and mysqli_query($conn1, $sql1) ) {
            $datos["rpta"] = "200";
            echo "CORRECTO";
        } else {
        $datos["rpta"] = "404";
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }


/*****************/
/*
$payload = json_encode($post);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://zonasegura.cmac-cusco.com.pe/wsrfid/ServiciosJson/EnvioDatosRFID.aspx',
  //CURLOPT_URL => 'https://laboratoriotransporteurbano.com/recepcionar.php',
  //CURLOPT_URL => 'http://200.37.108.22:8090/ServiciosJson/EnvioDatosRFID.aspx',
  //http://200.37.108.22:8090/ServiciosJson/EnvioDatosRFID.aspx
  //https://laboratoriotransporteurbano.com/test2.php
  //https://zonasegura.cmac-cusco.com.pe/wsrfid/ServiciosJson/EnvioDatosRFID.aspx
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_AUTOREFERER => true,
  CURLOPT_FOLLOWLOCATION => true,	 
  CURLOPT_POSTFIELDS =>$payload,	
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,	  
  CURLOPT_HTTPHEADER => array(	  
	'Content-Type: application/json; charset=UTF-8',
	'Content-Length: ' . strlen($payload)
  ),
));	

$response = curl_exec($curl);
echo $response;
curl_close($curl);
//echo json_encode($response);


session_destroy();

*/

?>