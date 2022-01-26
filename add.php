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


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $key => $value){
     if (isset($rules[$key])) {
          $rule = $rules[$key];
          $errors[$key] = $rule();
      }
    };
    if (is_uploaded_file($_FILES['lot-img']['tmp_name'])) {
        $rule = $rules['lot-img'];
        $errors['lot-img'] = $rule();
    }
    else {
        $errors['lot-img'] = "Загрузите изображение";
    }
};
$errors = array_filter($errors);
$form = include_template('add_lot.php', ['nav' => $nav_content, 'categories' => $category, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['main_content' => $form, 'container' => $container, 'title' => 'Главная', 'user_name' => $user_name, 'is_auth' => $is_auth, 'categories' => $category]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $file_name = $_FILES['lot-img']['name'];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;
    move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path . $file_name);
    $safe_name = mysqli_real_escape_string($con, $_POST['lot-name']);
    $safe_description = mysqli_real_escape_string($con, $_POST['message']);
    $sql_newLot = "INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ( NOW(), '$safe_name', '$safe_description', '$file_url', '{$_POST['lot-rate']}', '{$_POST['lot-date']}', '{$_POST['lot-step']}', '3', null, '{$_POST['category']}')";
    mysqli_query($con, $sql_newLot);
    header("Location: http://yeticave/lot.php?id=".mysqli_insert_id($con));
} else {
    print($layout_content);
};


?>