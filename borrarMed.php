<?php
    include 'config.php';
    $pdo = pdo_connect_mysql();
    $msg = '';
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * from medicamento where id_medicamento=?');
        $stmt->execute([$_GET['id']]);
        $med = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$med){
            exit('Medicamento no encontrado!');
        }

        if (isset($_GET['confirm'])) {
            if($_GET['confirm'] == 'yes'){
                $stmt = $pdo->prepare('DELETE FROM medicamento WHERE id_medicamento=?');
                $stmt->execute([$_GET['id']]);
    
                $msg = 'Se elimino Exitosamente!';
            }else{
                header('Location: medicamentos.php');
            }
        }
    }else{
        exit('No se especifico un ID');
    }
?>

<?=template_header('Eliminar')?>

<div class="content delete">
	<h2>Eliminar medicamento #<?=$med['id_medicamento']?></h2>
    <?php if ($msg): ?>
    <p>
        <?=$msg?><br>
        <a href="medicamentos.php" class="go-back">Regresar</a>
    </p>
    <?php else: ?>
    <p>Esta seguro de elimnar el medicamento #<?=$med['id_medicamento']?></p>
    <div class="yesno">
        <a href="borrarMed.php?id=<?=$med['id_medicamento']?>&confirm=yes">SI</a>
        <a href="borrarMed.php?id=<?=$med['id_medicamento']?>&confirm=no">NO</a>
    </div>
    <?php endif; ?>
    
</div>

<?=template_footer()?>