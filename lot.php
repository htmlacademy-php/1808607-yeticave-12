<?php
require_once('helpers.php');
$is_auth = rand(0, 1);
$user_name = 'Anastasiia';
$container = '';
$con = mysqli_connect("localhost", "root", "", "yeticave");
/*
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
 }
 else {
    print("Соединение установлено");
 }
 */

/** 
*Выделяем гатегории для навигации (верхнее меню)
* category категории из базы
*/
$sql_cat = "SELECT * FROM category";
$result_cat = mysqli_query($con, $sql_cat);
$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
/**
 * Формируем шаблон навигации
 */
$nav_content = include_template('navigation.php', ['categories' => $category]);

/** 
*Ищем нужный лот по ИД
* sql_lot - Запрос
* lot - Результат запроса
* ID выводим целое число из запроса
*/
$id = intval($_GET['id']);
$sql_lot = 'SELECT lot.name AS name_lot, start_price, category.name, image, date_end, description, rate_step
FROM lot 
LEFT JOIN category ON id_category = symbolic_code
WHERE lot.id = ' . $id;
$result_lot = mysqli_query($con, $sql_lot);
$lot = mysqli_fetch_assoc($result_lot);
/*
Проверка существования записи по ИД
*/
if (!$lot) {
	$error_content = include_template('404.php', ['nav' => $nav_content]);
    $layout_content = include_template('layout.php', ['main_content' => $error_content, 'container' => $container, 'title' => "404", 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);
}
else {
    $lot_content = include_template('lot_pages.php', ['nav' => $nav_content, 'name_lot' => $lot['name_lot'], 'category_name' => $lot['name'], 'description' => $lot['description'], 'image' => $lot['image'], 'date_end' => $lot['date_end'], 'start_price' => $lot['start_price'], 'rate_step' => $lot['rate_step']]);
    $layout_content = include_template('layout.php', ['main_content' => $lot_content, 'container' => $container, 'title' => $lot['name_lot'], 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);
}
print($layout_content);
?>