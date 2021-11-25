<?php
require_once('helpers.php');
$is_auth = rand(0, 1);
$user_name = 'Anastasiia'; // укажите здесь ваше имя

$con = mysqli_connect("localhost", "root", "", "yeticave");
$sql_cat = "SELECT * FROM category";
$result_cat = mysqli_query($con, $sql_cat);
$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
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

$form = include_template('add_lot.php', ['nav' => $nav_content, 'categories' => $category]);
$layout_content = include_template('layout.php', ['main_content' => $form, 'title' => 'Главная', 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);
print($layout_content);
?>