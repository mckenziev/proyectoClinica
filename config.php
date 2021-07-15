<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'clinica';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('No se pudo conectar a la Base!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html lang="es-ES">
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <title>$title</title>
	</head>
	<body class="body-form">
        <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="doctores.php">Doctores</a>
                <a href="pacientes.php">Pacientes</a>
                <a href="consultas.php">Consultas</a>
                <a href="Medicamentos.php">Medicamentos</a>
                <a href="logout.php">Salir</a>
        </div>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Opciones</span>
EOT;
}
function template_footer() {
echo <<<EOT
        <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
            document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
            }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.body.style.backgroundColor = "white";
        } 
        </script>
    </body>
</html>
EOT;
}
?>