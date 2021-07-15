<?php
    include 'config.php';
    $pdo = pdo_connect_mysql();
    $msg = '';

    if (!empty($_POST)) {
        
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
        
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $compuesto = isset($_POST['compuesto']) ? $_POST['compuesto'] : '';
        $productor = isset($_POST['productor']) ? $_POST['productor'] : '';

        $stmt = $pdo->prepare('INSERT INTO medicamento VALUES (?, ?, ?, ?)');
        $stmt->execute([$id, $nombre, $compuesto, $productor]);

        $msg = 'Creado Exitosamente!';
    }
?>

<?=template_header('Ingreso')?>

<div class="update content">
	<h2>Agregar Medicamento</h2>
    <form action="crearMed.php" method="post">
        <label for="id">ID</label>
        <label for="name">Nombre</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="nombre" placeholder="Paracetamol" id="nombre">
        <label for="email">Compuesto</label>
        <label for="phone">Productor</label>
        <input type="text" name="compuesto" placeholder="acetaminofén" id="compuesto">
        <input type="text" name="productor" placeholder="Pfizer" id="productor">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p>
        <?=$msg?>
    </p>
    <?php endif; ?>
    <a href="medicamentos.php" class="go-back">Regresar</a>
</div>

<?=template_footer()?>