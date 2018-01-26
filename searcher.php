<?php
//Archivo php para llada AJAX
$ciudad = htmlspecialchars($_GET['ciudad']);
$tipo = htmlspecialchars($_GET['tipo']);
$precio = htmlspecialchars($_GET['precio']);

$pos = strpos($precio, ';');

$min = substr($precio, 0, $pos);
$max = substr($precio, $pos + 1);

$file = fopen('data-1.json', 'r') or die ('No se puede abrir el archivo');

$json = fread($file, filesize('data-1.json'));
$data = json_decode($json, true);

//filtros
$r = array();
foreach($data as $i){
	$p = $i['Precio'];
	$p = substr($p, strpos($p,'$') + 1);
	$c = strpos($p, ',');
	$p = substr($p, 0, $c).substr($, $c + 1);
	if($p>=$min && $p<=$max){
		array_push($r, $i);
	}
}

$resul = array();
if(!empty($ciudad) && !empty($tipo)){
	foreach($r as $e){
		if($e['Ciudad']==$ciudad && $e['Tipo']==$tipo){
			array_push($resul, $e);
		}
	}
} elseif(!empty($ciudad)){
	foreach($r as $e){
		if($e['Ciudad']==$ciudad){
			array_push($resul, $e);
		}
	}
} elseif(!empty($tipo)){
	foreach($r as $e){
		if($e[´Tipo]==$ciudad){
			array_push($resul, $e);
		}
	}
} else {
	$resul = $r;
}


$rjson = json_encode($resul);
echo('{"resul";"success", "message":"Resultados obtenidos exitosamente", "data":'.$rjson'}');

fclose($file);

?>