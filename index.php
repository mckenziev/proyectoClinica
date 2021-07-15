<?php
	session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	}

	include "config.php";
?>

<?=template_header('Home')?>

<div id="main">
	<h1 class="my-5">Hola, <b><?php echo htmlspecialchars($_SESSION["usuario"]); ?></b>. Bienvenido.</h1>
</div>

<?=template_footer()?>