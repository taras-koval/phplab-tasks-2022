CREATE DATABASE online_shop;
USE online_shop;

CREATE TABLE `user` ( 
    id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,

    PRIMARY KEY (id), 
    UNIQUE (email)
);

INSERT INTO user (name, email, password) VALUES 
    ('Taras', 'tkoval37@gmail.com', '1111'),
    ('Bob', 'bob123@gmail.com', '1111'),
    ('Tom', 'tom@gmail.com', '1111'),
    ('Ostap', 'ostap@gmail.com', '1234'),
    ('Marko', 'marko@gmail.com', '1234'),
    ('Oksana', 'oksana@gmail.com', '1111');

CREATE TABLE category (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL DEFAULT NULL,

    PRIMARY KEY (id),
    UNIQUE (name)
);

INSERT INTO category (name, description) VALUES 
    ('Смартфони', 'Від бюджетних до іміджевих флагманів, наприклад, як Apple Iphone. Компактні або моделі зі зручним екраном. Білі, жовті, зелені, червоні з потужним акумулятором, великим об\'ємом пам\'яті та іншими важливими особливостями;'), 
    ('Комп\'ютери', 'Незамінними помічниками в повсякденному житті стали персональні комп\'ютери і ноутбуки, без яких вже неможливо уявити ні роботу, ні навчання, ні розваги. Сьогодні вони є практично в кожному будинку і офісі – це сучасний засіб зв\'язку і спілкування, інструмент для пошуку, обробки та зберігання інформації, а також відмінний спосіб проведення вільного часу. Кожен з пристроїв має свої плюси, які зумовили заслужену популярність.'), 
    ('Монітори', 'Запропоновані великі моделі і поменше, для бізнесу, портативні, геймерські, для роботи з кольором, з матовим і глянцевим покриттям, з вбудованою веб-камерою, колонками. А також із зігнутим і поворотним екраном, підтримкою 3D та іншими можливостями.');

CREATE TABLE product ( 
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    price DECIMAL UNSIGNED NOT NULL DEFAULT '0.0',
    description TEXT NULL DEFAULT NULL,
    availability ENUM('1','0') NOT NULL DEFAULT '1',

    PRIMARY KEY (id),
    INDEX (category_id),
    UNIQUE (name),
    FOREIGN KEY (category_id) REFERENCES category(id) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
);

INSERT INTO product (name, category_id, price, description, availability) VALUES 
    ('Apple iPhone 12 Pro Max', '1', '40499', 'Екран (6.7\", OLED (Super Retina XDR), 2778x1284) / Apple A14 Bionic / потрійна основна камера: 12 Мп + 12 Мп + 12 Мп, фронтальна камера: 12 Мп / 128 ГБ вбудованої пам\'яті / 3G / LTE / 5G / GPS / Nano-SIM / iOS 14', '1'), 
    ('Samsung Galaxy S21 Ultra', '1', '39999', 'Екран (6.8\", Dynamic AMOLED 2X, 3200x1440) / Samsung Exynos 2100 (1 x 2.9 ГГц + 3 x 2.8 ГГц + 4 x 2.2 ГГц) / основна квадрокамера: 108 Мп + 12 Мп + 10 Мп + 10 Мп, фронтальна : 40 Мп / RAM 12 ГБ / 256 ГБ вбудованої пам\'яті / 3G / LTE / 5G / GPS / підтримка 2 SIM-карток (Nano-SIM) / Android 11.0 / 5000 мА·год', '1'), 
    ('Xiaomi Mi 10T', '1', '13699', 'Екран (6.67\", 2400x1080) / Qualcomm Snapdragon 865 (2.84 ГГц) / потрійна основна камера: 64 Мп + 13 Мп + 5 Мп, фронтальна 20 Мп / RAM 8 ГБ / 128 ГБ вбудованої пам\'яті / 3G / LTE / 5G / GPS / підтримка 2 SIM-карток (Nano-SIM) / Android 10 / 5000 мА·год', '0'), 
    ('Apple MacBook Pro 13\"', '2', '44999', 'Екран 13.3\" Retina (2560x1600) WQXGA, глянсовий / Apple M1 / RAM 8 ГБ / SSD 256 ГБ / Apple M1 Graphics / без ОД / Wi-Fi / Bluetooth / вебкамера / macOS Big Sur / 1.4 кг / сірий\r\n\r\n', '1'), 
    ('Asus ROG Strix G15', '2', '29999', 'Екран 15.6\" IPS (1920x1080) Full HD 144 Гц, матовий / Intel Core i7-10750H (2.6 — 5.0 ГГц) / RAM 16 ГБ / SSD 512 ГБ / nVidia GeForce GTX 1650 Ti, 4 ГБ / без ОД / LAN / Wi-Fi / Bluetooth / без ОС / 2.39 кг / чорний', '0'), 
    ('Xiaomi Mi Notebook Pro', '2', '31599', 'Экран 15.6\" IPS (1920x1080) Full HD, глянцевый / Intel Core i7-10510U (1.8 - 4.9 ГГц) / RAM 16 ГБ / SSD 1 ТБ / nVidia GeForce MX250, 2 ГБ / без ОД / Wi-Fi / Bluetooth / веб-камера / Windows 10 Home / 1.95 кг / серый', '1'), 
    ('Samsung Odyssey G5', '3', '7777', 'Діагональ дисплея\r\n27\"\r\nМаксимальна роздільна здатність дисплея\r\n2560 x 1440\r\nЧас реакції матриці\r\n1 мс (GtG)\r\nЯскравість дисплея\r\n250 кд/м²\r\nТип матриці\r\nVA', '1'), 
    ('AOC 27G2U', '3', '6777', 'Діагональ дисплея\r\n27\"\r\nМаксимальна роздільна здатність дисплея\r\n1920 x 1080\r\nЧас реакції матриці\r\n1 мс\r\nЯскравість дисплея\r\n250 кд/м²\r\nТип матриці\r\nIPS', '0'), 
    ('Samsung Odyssey G7', '3', '16799', 'Діагональ дисплея\r\n31.5\"\r\nМаксимальна роздільна здатність дисплея\r\n2560 x 1440\r\nЧас реакції матриці\r\n1 мс (GtG)\r\nЯскравість дисплея\r\n600 кд/м²\r\nТип матриці\r\nVA', '1');

CREATE TABLE order_ ( 
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    product_id INT UNSIGNED NOT NULL,
    status ENUM('0','1','2') NOT NULL DEFAULT '1',

    PRIMARY KEY (id), 
    INDEX (user_id),
    INDEX (product_id)
);

ALTER TABLE order_ ADD 
FOREIGN KEY (product_id) REFERENCES product(id) 
ON DELETE CASCADE 
ON UPDATE CASCADE; 

ALTER TABLE order_ ADD 
FOREIGN KEY (user_id) REFERENCES user(id) 
ON DELETE CASCADE 
ON UPDATE CASCADE;

INSERT INTO order_ (user_id, date, product_id, status) VALUES 
    ('1', CURRENT_TIMESTAMP, '1', '1'), 
    ('1', CURRENT_TIMESTAMP, '4', '1'), 
    ('1', CURRENT_TIMESTAMP, '9', '0'), 
    ('2', CURRENT_TIMESTAMP, '8', '1'), 
    ('2', CURRENT_TIMESTAMP, '8', '1'), 
    ('3', CURRENT_TIMESTAMP, '1', '1'), 
    ('3', CURRENT_TIMESTAMP, '7', '2'), 
    ('4', CURRENT_TIMESTAMP, '5', '1'), 
    ('5', CURRENT_TIMESTAMP, '3', '1'), 
    ('5', CURRENT_TIMESTAMP, '5', '0');