<?php
$conexion = new mysqli("localhost","root","","vocacional2");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'] ?? '';
$area1 = $_POST['area1'] ?? '';
$puntaje1 = $_POST['puntaje1'] ?? 0;
$area2 = $_POST['area2'] ?? '';
$puntaje2 = $_POST['puntaje2'] ?? 0;

$stmt = $conexion->prepare("INSERT INTO resultados (nombre, area1, puntaje1, area2, puntaje2) VALUES (?,?,?,?,?)");
$stmt->bind_param("ssiss",$nombre,$area1,$puntaje1,$area2,$puntaje2);

if($stmt->execute()){
  echo "Guardado correctamente";
}else{
  echo "Error: ".$stmt->error;
}
$stmt->close();
$conexion->close();
?>
