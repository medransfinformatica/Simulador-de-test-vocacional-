<?php
$conexion = new mysqli("localhost","root","","vocacional2");
if ($conexion->connect_error) { die("Error de conexión: " . $conexion->connect_error); }

$res = $conexion->query("SELECT * FROM resultados ORDER BY fecha DESC");

$conteo = [];
$areas = ["TI","SALUD","EDU","ARTE","NEG","NAT"];
foreach($areas as $a){ $conteo[$a]=0; }

$r1 = $conexion->query("SELECT area1, COUNT(*) as c FROM resultados GROUP BY area1");
while($row=$r1->fetch_assoc()){ $conteo[$row['area1']] += $row['c']; }

$r2 = $conexion->query("SELECT area2, COUNT(*) as c FROM resultados GROUP BY area2");
while($row=$r2->fetch_assoc()){ $conteo[$row['area2']] += $row['c']; }

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Vocacional 2</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{font-family:Arial;background:#f4f6fa;margin:0}
header{background:#003366;color:#fff;padding:20px;text-align:center}
.wrap{max-width:1000px;margin:20px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.1)}
table{width:100%;border-collapse:collapse;margin-top:20px}
th,td{border:1px solid #ccc;padding:8px;text-align:center}
th{background:#003366;color:#fff}
canvas{margin-top:30px}
a.primary{padding:10px 15px;background:#28a745;color:#fff;border-radius:6px;text-decoration:none;}
</style>
</head>
<body>
<header><h1>Panel de Resultados Test Vocacional 2</h1></header>
<div class="wrap">
<a href="exportar2.php" class="primary">Exportar CSV</a>
<h2>📊 Estadísticas por Áreas</h2>
<canvas id="grafico"></canvas>

<h2>📋 Resultados individuales</h2>
<table>
<tr>
<th>ID</th><th>Nombre</th><th>Fecha</th><th>Área 1</th><th>Puntaje 1</th><th>Área 2</th><th>Puntaje 2</th>
</tr>
<?php while($row=$res->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['nombre']) ?></td>
<td><?= $row['fecha'] ?></td>
<td><?= $row['area1'] ?></td>
<td><?= $row['puntaje1'] ?></td>
<td><?= $row['area2'] ?></td>
<td><?= $row['puntaje2'] ?></td>
</tr>
<?php endwhile; ?>
</table>
</div>
<script>
const ctx = document.getElementById('grafico');
new Chart(ctx,{type:'bar',data:{labels:["Tecnología","Salud","Educación","Arte","Negocios","Naturales"],datasets:[{label:'Cantidad de estudiantes',data:[<?= $conteo['TI'] ?>,<?= $conteo['SALUD'] ?>,<?= $conteo['EDU'] ?>,<?= $conteo['ARTE'] ?>,<?= $conteo['NEG'] ?>,<?= $conteo['NAT'] ?>]}]}});
</script>
</body>
</html>
