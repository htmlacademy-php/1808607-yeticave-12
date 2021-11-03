INSERT INTO category SET symbolic_code = 'boards', name = 'Доски и лыжи';
INSERT INTO category SET symbolic_code = 'attachment', name = 'Крепления';
INSERT INTO category SET symbolic_code = 'boots', name = 'Ботинки';
INSERT INTO category SET symbolic_code = 'clothing', name = 'Одежда';
INSERT INTO category SET symbolic_code = 'tools', name = 'Инструменты';
INSERT INTO category SET symbolic_code = 'other', name = 'Разное';

INSERT INTO user (date_registration, name, email, password, contact) VALUES ('2020-10-08 12:35:29','Василий','vasya@mail.ru','secret', '+79997778989');
INSERT INTO user (date_registration, name, email, password, contact) VALUES ('2021-10-20 12:35:29','Владистава','vlad@mail.ru','secret123', '+79997779192');
INSERT INTO user (date_registration, name, email, password, contact) VALUES ('2021-01-15 12:35:29','Петр','petr@mail.ru','qwerty123', '+79997776258');

INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-02-05 10:35:40', '2014 Rossignol District Snowboard', 'Сноуборд Rossignol District Amptek - это удобная доска для фристайла для начинающих райдеров и пайпрайдеров.', 'img/lot-1.jpg', '11000', '2021-09-21', '100', '1', null, 'boards');
INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-06-20 15:55:41', 'DC Ply Mens 2016/2017 Snowboard', 'Отзывчивый сноуборд с действительно интересным прогибом Lock & Load Camber, который обладает силуэтом классического кэмбера, но при этом имеет более удлиненную контактную зону, которая добавит стабильности и мощности щелчка.', 'img/lot-2.jpg', '159999', '2021-09-26', '100', '1', null, 'boards');
INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-12-05 11:33:20', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Невероятно легкие универсальные крепления Contact Pro готовы порадовать прогрессирующих райдеров, практикующих как трассовое катание, так и взрывные спуски в паудере.', 'img/lot-3.jpg', '8000', '2021-09-24', '100', '1', null, 'attachment');
INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-01-01 05:20:30', 'Ботинки для сноуборда DC Mutiny Charocal', 'Эти ботинки созданы для фристайла и для того, чтобы на любом споте Вы чувствовали себя как дома в уютных тапочках, в которых Вы будете также прекрасно чувствовать свою доску, как ворсинки на любимом коврике около дивана.', 'img/lot-4.jpg', '10999', '2021-09-22', '500', '2', null, 'boots');
INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-02-10 01:15:35', 'Куртка для сноуборда DC Mutiny Charocal', 'Сноубордическая куртка', 'img/lot-5.jpg', '7500', '2021-09-23', '150', '2', null, 'clothing');
INSERT INTO lot (date_create, name, description, image, start_price, date_end, rate_step, id_author, id_winner, id_category) VALUES ('2021-10-10 13:40:15', 'Маска Oakley Canopy', 'Увеличенный объем линзы и низкий профиль оправы маски Canopy способствуют широкому углу обзора, а специальное противотуманное покрытие поможет ориентироваться в условиях плохой видимости. Технология вентиляции O-Flow Arch и прослойка из микрофлиса сделают покорение горных склонов более комфортным. ', 'img/lot-6.jpg', '5400', '2021-09-23', '100', '3', null, 'other');

INSERT INTO rate (date_add, price, id_user, id_lot) VALUES ('2021-02-06 11:45:40','11100','1','1');
INSERT INTO rate (date_add, price, id_user, id_lot) VALUES ('2021-02-07 09:45:05','11200','2','1');
INSERT INTO rate (date_add, price, id_user, id_lot) VALUES ('2021-06-25 18:23:05','160099','2','2');


/*  
получить все категории  
*/ 
SELECT * FROM category

/*  
получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории  
*/ 
SELECT lot.name, start_price, image, category.name
FROM lot 
LEFT JOIN category ON id_category = symbolic_code
ORDER BY date_create DESC
LIMIT 1

/*  
показать лот по его ID. Получите также название категории, к которой принадлежит лот  
*/ 
SELECT lot.name, start_price, category.name
FROM lot 
LEFT JOIN category ON id_category = symbolic_code
WHERE lot.id = 1

/*  
обновить название лота по его идентификатору  
*/ 
UPDATE lot SET lot.name="2014 Rossignol District Snowboard" WHERE id=1

/*  
получить список ставок для лота по его идентификатору с сортировкой по дате  
*/ 

SELECT id_user, rate.price, lot.name, category.name
FROM lot
LEFT JOIN category ON id_category = symbolic_code
LEFT JOIN rate ON lot.id = id_lot
WHERE lot.id = 1
ORDER BY date_add DESC