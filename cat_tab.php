<?php

require_once('./autoloader.php');

use App\Model\AdminModel;

$controllerCat = new AdminModel();
$showTabCat = $controllerCat->showCat();
$showTabSubCat = $controllerCat->showSubCat();
// var_dump($showTabSubCat);


// var_dump($showTabCat);

?>


<form action="" method="POST" id="form_check_cat">
    <table id="table_cat">
        <thead>
            <tr>
                <th>Category</th>
                <th>Sub Category</th>
            </tr>
        </thead>
        <tbody id="tb_cat">

            <tr class="row_cat" id="rowcat1">
               
                <?php foreach($showTabCat as $showtab) : ?>
                    <td><label for="<?= $showtab['category']?>"><?= $showtab['category']?></label>
                        <input type="checkbox" id="check" class="check_cat" name="checkcat[]" value="<?= $showtab['id']?>">
                    </td>
                    <?php endforeach ; ?>
                </tr>
                <!-- <button type="submit" id="del-cat" name="btn_del_cat" value="">Delete Category</button> -->
            <tr class="row_cat" id="rowcat2">
               
                <?php foreach($showTabSubCat as $showtab) : ?>
                    <td><label for="<?= $showtab['subcategory']?>"><?= $showtab['subcategory']?></label>
                        <input type="checkbox" id="checksub" class="check_subcat" name="checksubcat[]" value="<?= $showtab['id']?>">
                    </td>
                    <?php endforeach ; ?>
                </tr>
                <!-- <button type="submit" id="del-cat" name="btn_del_cat" value="">Delete SubCategory</button> -->
        </tbody>
    </table>
    <button type="submit" id="del-cat" name="btn_del_cat" value="">Delete Category</button>
    <button type="submit" id="del-cat" name="btn_del_cat" value="">Delete SubCategory</button>

</form>