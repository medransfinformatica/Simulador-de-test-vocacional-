<?php
// testvocacional2.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Test Vocacional 2</title>
  <style>
    body{font-family:Arial;background:#f4f6fa;margin:0}
    header{background:#003366;color:#fff;padding:20px;text-align:center}
    .wrap{max-width:1000px;margin:20px auto;padding:20px;background:#fff;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.1)}
    .question{margin-bottom:15px}
    button{padding:10px 18px;margin:10px 5px;border:none;border-radius:6px;font-weight:bold;cursor:pointer}
    .primary{background:#28a745;color:#fff}
    #resultado{display:none;margin-top:20px;padding:15px;border:1px solid #ccc;border-radius:8px}
    h3{margin-bottom:5px;margin-top:15px;}
  </style>
</head>
<body>
<header>
  <h1>Test Vocacional 2</h1>
  <p>Responde y descubre tus áreas de interés y posibles carreras</p>
</header>
<div class="wrap">
  <form id="formTest">
    <label>Tu nombre: <input type="text" id="nombre" required></label>
    <div id="preguntas"></div>
    <button type="button" class="primary" id="btnCalcular">Calcular resultado</button>
  </form>
  <div id="resultado"></div>
</div>

<script>
const AREAS_INFO = {
  TI: {
    nombre: "Tecnología e Informática",
    carreras: ["Ingeniería en Sistemas", "Licenciatura en Informática", "Desarrollo de Videojuegos"],
    universidades: ["UBA", "UTN", "UNER"],
    recomendaciones: "Si te apasiona resolver problemas con computadoras y la programación, estas carreras te permitirán trabajar en empresas de tecnología, crear tus propios proyectos o desarrollar soluciones innovadoras."
  },
  SALUD: {
    nombre: "Ciencias de la Salud",
    carreras: ["Medicina", "Enfermería", "Nutrición"],
    universidades: ["UBA", "UNLP", "UNER"],
    recomendaciones: "Si te gusta ayudar a otros y te interesa el cuerpo humano y la salud, estas carreras te permitirán trabajar en hospitales, clínicas o investigación biomédica."
  },
  EDU: {
    nombre: "Educación y Social",
    carreras: ["Profesorado de Nivel Inicial", "Profesorado de Secundaria", "Trabajo Social"],
    universidades: ["UBA", "UNLP", "UNNE"],
    recomendaciones: "Si disfrutas enseñar o ayudar a personas y comunidades, estas carreras te permitirán trabajar en escuelas, organizaciones sociales y proyectos educativos."
  },
  ARTE: {
    nombre: "Arte y Diseño",
    carreras: ["Diseño Gráfico", "Artes Visuales", "Diseño de Indumentaria"],
    universidades: ["UBA", "UNER", "UNC"],
    recomendaciones: "Si te apasiona la creatividad, el diseño y la expresión artística, estas carreras te permitirán trabajar en diseño gráfico, moda, arte digital o artes plásticas."
  },
  NEG: {
    nombre: "Negocios y Economía",
    carreras: ["Contador Público", "Economía", "Administración de Empresas"],
    universidades: ["UBA", "UNLP", "UTN"],
    recomendaciones: "Si te interesa el dinero, la gestión y los negocios, estas carreras te permitirán trabajar en empresas, finanzas, consultoría o emprender tu propio negocio."
  },
  NAT: {
    nombre: "Ciencias Naturales",
    carreras: ["Biología", "Química", "Geología"],
    universidades: ["UBA", "UNLP", "UNNE"],
    recomendaciones: "Si te fascina la naturaleza y la ciencia, estas carreras te permitirán investigar el ambiente, los seres vivos y procesos naturales, trabajando en investigación o conservación."
  }
};

// 30 preguntas
const PREGUNTAS = [
  {t:"Me gusta resolver problemas con computadoras.",a:["TI"]},
  {t:"Disfruto ayudar a las personas y su bienestar.",a:["SALUD"]},
  {t:"Me interesa enseñar o explicar a otros.",a:["EDU"]},
  {t:"Tengo interés por el arte y el diseño.",a:["ARTE"]},
  {t:"Me atraen los negocios, el dinero y la gestión.",a:["NEG"]},
  {t:"Me apasiona la naturaleza y la ciencia.",a:["NAT"]},
  {t:"Me gusta crear páginas web, apps o videojuegos.",a:["TI","ARTE"]},
  {t:"Me gusta investigar cómo funciona el cuerpo humano.",a:["SALUD"]},
  {t:"Prefiero trabajar en equipo.",a:["EDU","NEG"]},
  {t:"Me interesa el cuidado del ambiente.",a:["NAT"]},
  {t:"Me interesa la robótica y la inteligencia artificial.",a:["TI"]},
  {t:"Disfruto leer sobre psicología o comportamiento humano.",a:["EDU","SALUD"]},
  {t:"Me gusta dibujar, pintar o crear imágenes digitales.",a:["ARTE"]},
  {t:"Siento curiosidad por cómo funciona la economía.",a:["NEG"]},
  {t:"Me interesa la biología y los animales.",a:["NAT"]},
  {t:"Me gusta analizar datos y estadísticas.",a:["TI","NEG"]},
  {t:"Me atrae la medicina y la investigación clínica.",a:["SALUD"]},
  {t:"Me motiva enseñar a niños o jóvenes.",a:["EDU"]},
  {t:"Me gusta el cine, la fotografía o el teatro.",a:["ARTE"]},
  {t:"Quiero emprender mi propio negocio.",a:["NEG"]},
  {t:"Tengo interés en energías renovables.",a:["NAT"]},
  {t:"Disfruto aprender lenguajes de programación.",a:["TI"]},
  {t:"Me interesa la nutrición y la vida saludable.",a:["SALUD"]},
  {t:"Quiero ayudar a personas con dificultades de aprendizaje.",a:["EDU"]},
  {t:"Me gusta diseñar objetos o moda.",a:["ARTE"]},
  {t:"Me interesa el comercio internacional.",a:["NEG"]},
  {t:"Me atrae la química y los experimentos.",a:["NAT"]},
  {t:"Sueño con trabajar en ciberseguridad.",a:["TI"]},
  {t:"Quiero colaborar en hospitales o centros de salud.",a:["SALUD"]}
];

const preguntasDiv=document.getElementById("preguntas");
PREGUNTAS.forEach((p,i)=>{
  const div=document.createElement("div");div.className="question";
  div.innerHTML=`<p>${i+1}. ${p.t}</p>
    <label><input type='radio' name='q${i}' value='1'> Sí</label>
    <label><input type='radio' name='q${i}' value='0'> No</label>`;
  preguntasDiv.appendChild(div);
});

document.getElementById("btnCalcular").addEventListener("click",()=>{
  let nombre=document.getElementById("nombre").value.trim();
  if(!nombre){alert("Escribe tu nombre");return;}
  let puntajes={TI:0,SALUD:0,EDU:0,ARTE:0,NEG:0,NAT:0};
  PREGUNTAS.forEach((p,i)=>{
    let val=document.querySelector(`input[name=q${i}]:checked`);
    if(val && val.value=="1"){p.a.forEach(a=>puntajes[a]++);}
  });
  let top=Object.entries(puntajes).sort((a,b)=>b[1]-a[1]).slice(0,2);
  document.getElementById("resultado").style.display="block";

  let resultadoHTML = `<h2>Resultado</h2>`;
  top.forEach(t=>{
    const info = AREAS_INFO[t[0]];
    resultadoHTML += `<h3>${info.nombre} – ${t[1]} pts</h3>`;
    resultadoHTML += `<p><b>Carreras sugeridas:</b><br>- ${info.carreras.join("<br>- ")}</p>`;
    resultadoHTML += `<p><b>Universidades recomendadas:</b> ${info.universidades.join(", ")}</p>`;
    resultadoHTML += `<p><b>Recomendaciones:</b> ${info.recomendaciones}</p>`;
  });
  document.getElementById("resultado").innerHTML = resultadoHTML;

  // Guardar en base de datos
  fetch("guardar2.php",{
    method:"POST",
    headers:{"Content-Type":"application/x-www-form-urlencoded"},
    body:`nombre=${encodeURIComponent(nombre)}&area1=${top[0][0]}&puntaje1=${top[0][1]}&area2=${top[1][0]}&puntaje2=${top[1][1]}`
  }).then(r=>r.text()).then(txt=>console.log(txt));
});
</script>
</body>
</html>
