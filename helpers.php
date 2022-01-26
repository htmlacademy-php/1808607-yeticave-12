<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}
//Функция по форматированию суммы. Принимает стоимсоть, округляет и выводит с разделением тысячных
function format_amount($amount){
    $str_amount = "";
    $currency = " ₽";
    $amount = ceil($amount);
    $str_amount = number_format($amount, 0, '.', ' ');
    $str_amount .= $currency; 
    return $str_amount;
}; 
//Функция по выводу таймера до окончания продажи товара. Получает дату окончания из товара. рассчитывает разницу на данный момент и формирует массив [hour, min]
function time_left($end_date){
    $now = strtotime("now");
    $future = strtotime($end_date);
    $diff_sek = $future - $now;
    $diff_hour = floor($diff_sek/3600);
    $diff_min = floor(($diff_sek - $diff_hour*3600)/60);
    return array('hour' => $diff_hour,
                 'min' => $diff_min);
}

//Функция для сохранения значений из формы
function getPostVal($name) {
    return $_POST[$name] ?? "";
}

//Функция для проверки заполненности
function validateFilled($name) {
    if (empty($_POST[$name])) {
        return "Это поле должно быть заполнено";
    }
}

//Функция для проверки заполненности категории
function validateCategory($name) {
    if ($_POST[$name] === "Выберите категорию") {
        return "Выберите категорию";
    }
}

//Функция для проверки вводимых сумм
function validateRate($name) {
    if ((!filter_input(INPUT_POST, $name, FILTER_VALIDATE_INT)) OR ((int)$_POST[$name] < 0)) {
        return "Введите корректную сумму";
    }
}

//Функция для проверки даты
function validateDate($name) {
    if (!is_date_valid($_POST[$name])) {
        return "Введите корректную дату";
    }
    else {
        $today = date('Y-m-d');
        if ($today >= $_POST[$name]) {
            return "Введите корректную дату";
        }
    }
}

//Функция валидации файла
function validateFile($name) {
    if (!in_array(mime_content_type($_FILES[$name]['tmp_name']) ,['image/png', 'image/jpeg'])) {
        return "Загрузите картинку в верном формате";
    }
}