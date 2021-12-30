<?php
require_once('helpers.php');
$is_auth = rand(0, 1);
$user_name = 'Anastasiia'; // укажите здесь ваше имя
$container = '';
$con = mysqli_connect("localhost", "root", "", "yeticave");
$sql_cat = "SELECT * FROM category";
$result_cat = mysqli_query($con, $sql_cat);
$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
$errors = [];
$rules = [
    'lot-name' => function(){
        return validateFilled('lot-name');
    },
    'category' => function() {
        return validateCategory('category');
    },
    'message' => function(){
        return validateFilled('message');
    },
    'lot-rate' => function(){
        return validateRate('lot-rate');
    },
    'lot-step' => function(){
        return validateRate('lot-step');
    },
    'lot-date' => function(){
        return validateDate('lot-date');
    },
    'lot-img' => function(){
        return validateFile('lot-img');
    }
];
/**
 * Формируем шаблон навигации
 */
$nav_content = include_template('navigation.php', ['categories' => $category]);

//$sql_lot = "SELECT lot.name AS name_lot, start_price, image, category.name, date_end, lot.id AS lot_id
//FROM lot 
//LEFT JOIN category ON id_category = symbolic_code
//WHERE date_end > CURRENT_DATE()
//ORDER BY date_create DESC";
//$result_lot = mysqli_query($con, $sql_lot);
//$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
if ($_SERVER["REQUEST_METHOD"] === "POST")
foreach ($_POST as $key => $value){
    if (isset($rules[$key])) {
      //  $_POST[$key] = htmlspecialchars($value, ENT_QUOTES,"UTF-8");
        $rule = $rules[$key];
        $errors[$key] = $rule();
    }
}
$errors = array_filter($errors);
$form = include_template('add_lot.php', ['nav' => $nav_content, 'categories' => $category, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['main_content' => $form, 'container' => $container, 'title' => 'Главная', 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);
var_dump(mime_content_type($_FILES['lot-img']));
var_dump($_FILES['lot-img']);
//var_dump($_POST['lot-date']);
//if ($_SERVER["REQUEST_METHOD"] === "POST")




($_SERVER["REQUEST_METHOD"] === "POST") ? print($layout_content) : print($layout_content);
?>