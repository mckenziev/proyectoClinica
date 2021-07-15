<?php
    session_start();
        
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    include "config.php";


    $pdo = pdo_connect_mysql();

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

    $filtro = isset($_GET['b']) ? $_GET['b'] : '';
    $filtro = trim($filtro, '%');
    $filtro = "%". $filtro . "%";
    $records_per_page = 5;
    $consulta = "SELECT * FROM medicamento where nombre like :filtro ORDER BY 1 LIMIT :current_page, :record_per_page"; 
    $stmt = $pdo->prepare($consulta);
    $stmt->bindValue(':filtro', $filtro, PDO::PARAM_STR);
    $stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);    
    $stmt->execute();
    $meds = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) FROM medicamento where nombre like '" .$filtro . "'";
    $num_meds = $pdo->query($consulta)->fetchColumn();
?>

<?=template_header('Medicamentos')?>
<div class="main">
    <div class="content read">
        <h2>Medicamentos</h2>
        <a href="crearMed.php" class="create-contact">Agregar Medicamento</a>
        <form action="medicamentos.php" method="get">
            <input class="find" type="text" name="b" placeholder="Buscar" value="<?=trim($filtro, '%')?>" id="b">
            <input class="find" type="text" name="a" placeholder="Buscar" value="<?=trim($filtro, '%')?>" id="a">
            <input type="submit" value="Buscar">
        </form>
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nombre</td>
                    <td>Compuesto</td>
                    <td>Productor</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meds as $med): ?>
                <tr>
                    <td><?=$med['id_medicamento']?></td>
                    <td><?=$med['nombre']?></td>
                    <td><?=$med['compuesto']?></td>
                    <td><?=$med['productor']?></td>
                    <td class="actions">
                        <a href="updateMed.php?id=<?=$med['id_medicamento']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="borrarMed.php?id=<?=$med['id_medicamento']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
            <a href="medicamentos.php?page=<?=$page-1?>&b=<?=$filtro?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page*$records_per_page < $num_meds): ?>
            <a href="medicamentos.php?page=<?=$page+1?>&b=<?=$filtro?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?=template_footer()?>