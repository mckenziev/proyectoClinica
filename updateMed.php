<?php
    include 'config.php';
    $pdo = pdo_connect_mysql();
    $msg = '';
    if (isset($_GET['id'])) {
        if (!empty($_POST)) {
            
            $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
            
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $compuesto = isset($_POST['compuesto']) ? $_POST['compuesto'] : '';
            $productor = isset($_POST['productor']) ? $_POST['productor'] : '';

            $stmt = $pdo->prepare('UPDATE medicamento SET nombre=?, compuesto=?, productor=? WHERE id_medicamento=?');
            $stmt->execute([ $nombre, $compuesto, $productor, $_GET['id']]);

            $msg = 'Actualizado Exitosamente!';
        }
        $stmt = $pdo->prepare('SELECT * FROM medicamento WHERE id_medicamento=?');
        $stmt->execute([$_GET['id']]);
        $med = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$med){
            exit('Medicamento no encontrado!');
        }
    }else{
        exit('No se especifico un ID');
    }
?>

<?=template_header('Actualizar')?>

<div class="content update">
	<h2>Actualizar Medicamento #<?=$med['id_medicamento']?></h2>
    <form action="updateMed.php?id=<?=$med['id_medicamento']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Nombre</label>
        <input type="text" name="id" placeholder="1" value="<?=$med['id_medicamento']?>" id="id">
        <input type="text" name="nombre" placeholder="Paracetamol" value="<?=$med['nombre']?>"  id="nombre">
        <label for="email">Compuesto</label>
        <label for="phone">Productor</label>
        <input type="text" name="compuesto" placeholder="acetaminofén" value="<?=$med['compuesto']?>"  id="compuesto">
        <input type="text" name="productor" placeholder="Pfizer" value="<?=$med['productor']?>"  id="productor">
        <input type="submit" value="Actualizar">
    </form>
    <?php if ($msg): ?>
    <p>
        <?=$msg?>
    </p>
    <?php endif; ?>
    <a href="medicamentos.php" class="go-back">Regresar</a>
</div>

<?=template_footer()?>