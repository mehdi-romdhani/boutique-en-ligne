<?php
require_once ("autoloader.php");

use App\Controller\AdminControllerGame;
use App\Model\AdminModel;


$AdminController = new  AdminControllerGame();

$AdminController->fetchLastGame();

$getPlatform = $AdminController->getPlatform();

$getCategory = $AdminController->getCategory();

$getSubCategory = $AdminController->getSubCategory();



if(isset($_GET['formAddGame'])):
?>
<?php if(isset($_GET['updateGame'])) { $getValue = $AdminController->searchGameById($_POST['id_update']); $compatId = $AdminController->findCompatibility($_POST['id_update']);} ?>

<form id="formGame" method="post">
    <div id="error-field"></div>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['title'];} ?>">
    <div id="error-title"></div>

    <label for="desc">Description</label>
    <textarea name="desc" id="desc" cols="30" rows="10" ><?php if(isset($_GET['updateGame'])) { echo $getValue['description'];} ?></textarea>
    <div id="error-desc"></div>

    <label for="price">Price</label>
    <input type="number" id="price" name="price" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['price'];} ?>">
    <div id="error-price"></div>

    <label for="image">Image</label>
    <input type="text" name="image" id="image" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['image'];} ?>">

    <label for="release_date">Release date</label>
    <input type="date" name="release_date" id="release_date" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['release_date'];} ?>">

    <label for="developper">Developper</label>
    <input type="text" name="developper" id="developper" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['developper'];} ?>">

    <label for="publisher">Publisher</label>
    <input type="text" name="publisher" id="publisher" value="<?php if(isset($_GET['updateGame'])) { echo $getValue['publisher'];} ?>">

    <?php foreach ($getPlatform as $key => $platform):  ?>
        <label for="platform"><?php echo $platform['platform'] ?></label>
        <input type="checkbox" name="check_list[]" class="platform" value="<?php echo $platform['id'] ?>" <?php if(isset($_GET['updateGame'])) {foreach($compatId as $checkbox) { if($platform['id'] == $checkbox['id_platform']) { echo "checked";} }} ?>/>
    <?php endforeach;  ?>
    <div id="error-checkbox"></div>


    <label for="category">Category</label>
    <select name="category" id="category">
    <?php foreach($getCategory as $key => $category): ?>
        <option value="<?php echo $category['id']; ?>" <?php if(isset($_GET['updateGame'])) { if ($category['id'] === $getValue['id_category']) {echo "selected";}} ?> > <?php echo $category['category'];  ?></option>
    <?php endforeach; ?>
    </select>

    <label for="subcategory">Sub-scategory</label>
    <select name="subcategory" id="subcategory">
        <?php foreach($getSubCategory as $key => $subCategory): ?>
            <option value="<?php echo $subCategory['id']; ?>" <?php if(isset($_GET['updateGame'])) { if ($subCategory['id'] === $getValue['id_subcategory']) {echo "selected";}} ?>> <?php echo $subCategory['subcategory'] ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" id="submitGame" name="submitGame">
</form>
<?php
    die(); endif
?>
<?php


    !isset($_GET['submitGame']) ?: $AdminController->insertGame($_POST["title"], $_POST["desc"], $_POST["price"], $_POST["image"], $_POST["release_date"], $_POST["developper"], $_POST["publisher"], $_POST['check_list'], $_POST["category"], $_POST["subcategory"]);

    !isset($_GET['updateGame']) ?: $AdminController->updateGame($_POST["title"], $_POST["desc"], $_POST["price"], $_POST["image"], $_POST["release_date"], $_POST["developper"], $_POST["publisher"], $_POST['check_list'], $_POST["category"], $_POST["subcategory"], $_POST['id']) ;


    !isset($_GET['showGame']) ?: $AdminController->displayGames();

    !isset($_GET['deleteGame']) ?: $AdminController->deleteGame($_POST['id']);


?>