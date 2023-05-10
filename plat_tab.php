<?php
require_once("autoloader.php");

use App\Controller\PlateformController;

$controller = new PlateformController();
$plateform = $controller->showPlateform();

!isset($_GET['idPlat']) ?: $controller->deletePlat($_POST['checkplat']);


?>

<form action="" method="POST" id="form_check_plat">
    <table id="table_plate">
        <thead>
            <tr>
                <th>Platforms</th>
            </tr>
        </thead>
        <tbody id="tb_plat">
            <tr class="row_plat">
                <?php foreach ($plateform as $plat) : ?>
                    <td><label for="<?= $plat['id'] ?>"><?= $plat['platform'] ?></label>
                        <input type="checkbox" id="<?= $plat['id'] ?>" class="check_plat" name="checkplat[]" value="<?= $plat['id'] ?>">
                    </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
    <button type="submit" id="del-plat" name="btn_del" value="">Delete Plateform</button>
</form>