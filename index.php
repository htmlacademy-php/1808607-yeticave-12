<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

$user_name = 'Anastasiia'; // укажите здесь ваше имя
$categories = [
    "Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты",
    "Разное"
];
$lots = [
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
function format_amount($amount){
    $str_amount = "";
    $currency = " ₽";
    $amount = ceil($amount);
    $str_amount = number_format($amount, 0, '.', ' ');
    $str_amount .= $currency; 
    return $str_amount;
}; 
function time_left($end_date){
    $now = strtotime("now");
    $future = strtotime($end_date);
    $finishing = 0;
    $diff_sek = $future - $now;
    $diff_hour = floor($diff_sek/3600);
    $diff_min = floor(($diff_sek - $diff_hour*3600)/60);
    $diff = $diff_hour . ":" . $diff_min;
    if ($diff <= 0) {$finishing = 1;}
    return(array('time' => $diff,
                 'finish' => $finishing));
}
$main_content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
$layout_content = include_template('layout.php', ['main_content' => $main_content, 'title' => 'Главная', 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $categories]);
print($layout_content);
?>