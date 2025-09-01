<?php
$conexion = new mysqli("localhost","root","","vocacional2");
if ($conexion->connect_error) { die("Error de conexión: " . $conexion->connect_error); }

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=resultados_test2.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Nombre','Fecha','Área 1','Puntaje 1','Área 2','Puntaje 2']);

$res = $conexion->query("SELECT * FROM resultados ORDER BY fecha DESC");
while($row = $res->fetch_assoc()){ fputcsv($output, $row); }

fclose($output);
$conexion->close();
?>
