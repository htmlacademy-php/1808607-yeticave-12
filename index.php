<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

$user_name = 'Anastasiia'; // укажите здесь ваше имя
$con = mysqli_connect("localhost", "root", "", "yeticave");
$sql_cat = "SELECT * FROM category";
$result_cat = mysqli_query($con, $sql_cat);
$category = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$container = 'container';

/*if ($con == false) {
   print("Ошибка подключения: " . mysqli_connect_error());
}
else {
   print("Соединение установлено");
	// выполнение запросов
}*/
/*
$categories = [
    [
        'symbolic_code' => 'boards',
        'name' => 'Доски и лыжи',
    ],
    [
        'symbolic_code' => 'attachment',
        'name' => 'Крепления',
    ],
    [
        'symbolic_code' => 'boots',
        'name' => 'Ботинки',
    ],
    [
        'symbolic_code' => 'clothing',
        'name' => 'Одежда',
    ],
    [
        'symbolic_code' => 'tools',
        'name' => 'Инструменты',
    ],
    [
        'symbolic_code' => 'other',
        'name' => 'Разное',
    ]
];
*/
$sql_lot = "SELECT lot.name AS name_lot, start_price, image, category.name, date_end, lot.id AS lot_id
FROM lot 
LEFT JOIN category ON id_category = symbolic_code
WHERE date_end > CURRENT_DATE()
ORDER BY date_create DESC";
$result_lot = mysqli_query($con, $sql_lot);
$lots = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
/*
$lotss = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999.99,
        'image_url' => 'img/lot-1.jpg',
        'date_end' => "2021-09-21",
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'image_url' => 'img/lot-2.jpg',
        'date_end' => "2021-09-26",
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'image_url' => 'img/lot-3.jpg',
        'date_end' => "2021-09-24",
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'image_url' => 'img/lot-4.jpg',
        'date_end' => "2021-09-22",
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'image_url' => 'img/lot-5.jpg',
        'date_end' => "2021-09-23",
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' =>	5400,
        'image_url' => 'img/lot-6.jpg',
        'date_end' => "2021-09-23",
    ],
];
*/

$main_content = include_template('main.php', ['categories' => $category, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['main_content' => $main_content, 'container' => $container, 'title' => 'Главная', 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);
print($layout_content);
?>