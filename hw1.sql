CREATE DATABASE hw1;
USE hw1;

CREATE TABLE users (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  surname varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  password varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE vehicle (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  brand varchar(255) NOT NULL,
  model varchar(255) NOT NULL,
  version varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE products (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  short_desc varchar(255) NOT NULL,
  image_path varchar(255) DEFAULT 'assets/no_image.png',
  brand_image_path varchar(255) NOT NULL,
  details json NOT NULL,
  category varchar(255) NOT NULL,
  product_number varchar(255) NOT NULL,
  price float NOT NULL,
  quantity int(11) NOT NULL,
  rating int(11) NOT NULL
  
) ENGINE=InnoDB;

CREATE TABLE cart (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  created datetime NOT NULL,  
  FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB;

CREATE TABLE cart_products (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  cart_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  amount int(11) NOT NULL,
  
  FOREIGN KEY (cart_id) REFERENCES cart (id),
  FOREIGN KEY (product_id) REFERENCES products (id)
) ENGINE=InnoDB;

CREATE TABLE address (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  cart_id int(11) NOT NULL,
  name varchar(255) NOT NULL,
  surname varchar(255) NOT NULL,
  business_address int(1) NOT NULL,
  cf varchar(16) DEFAULT NULL,
  way varchar(255) NOT NULL,
  way_number varchar(10) NOT NULL,
  cap int(5) NOT NULL,
  city varchar(255) NOT NULL,
  country varchar(255) NOT NULL,
  phone_area_code varchar(255) NOT NULL,
  phone_number varchar(15) NOT NULL,
  
  FOREIGN KEY (cart_id) REFERENCES cart (id)
) ENGINE=InnoDB;

CREATE TABLE compatibility (
  vehicle_id int(11) NOT NULL,
  parts_id int(11) NOT NULL,
  FOREIGN KEY (vehicle_id) REFERENCES vehicle (id),
  FOREIGN KEY (parts_id) REFERENCES products (id)
) ENGINE=InnoDB;

CREATE TABLE licence_plates (
  id_vehicle int(11) NOT NULL,
  licence_plate varchar(255) NOT NULL,
  FOREIGN KEY (id_vehicle) REFERENCES vehicle (id)
) ENGINE=InnoDB;

CREATE TABLE orders (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  user_id int(11) DEFAULT NULL,
  cart_id int(11) NOT NULL,
  address_id int(11) NOT NULL,
  receipt_url varchar(255) DEFAULT NULL,
  
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (address_id) REFERENCES address (id),
  FOREIGN KEY (cart_id) REFERENCES cart (id)
) ENGINE=InnoDB;


INSERT INTO users (id, password, email, name, surname) VALUES
(1, '$2y$10$ugLojfLHTSAyU365s8W/POH3DY2x34EWqA54.MCUSeOv7ibymuyGe', 'mario@rossi.com', 'Mario', 'Rossi'),
(23, '$2y$10$f1KgDcdn/3akfyE7UOc9H.m2FM.2QaNmWDRjndHTJVrJ5Q0onQXBm', 'mario@gmail.com', 'Mario', 'Verdi'),
(29, '$2y$10$AOsHfIIvZ76PBuqRCOB2K.agPx40BHqS0TYmz/Q5zLH8u2xyJJLJS', 'mario@gialli.com', 'Mario', 'Gialli'),
(30, '$2y$10$.Y677NT2L0ed4LMk7pnF2OCmMnKMHzWtMDKtNQhbMa.sqarYxh4eq', 'mario@bianchi.com', 'Mario', 'Bianchi');


INSERT INTO cart (id, user_id, created) VALUES
(68, NULL, '2024-06-04 12:28:41'),
(75, 1, '2024-06-05 17:14:11'),
(76, 29, '2024-06-05 18:00:39'),
(77, 30, '2024-06-05 18:00:56');

INSERT INTO address (id, cart_id, name, surname, business_address, cf, way, way_number, cap, city, country, phone_area_code, phone_number) VALUES
(23, 68, 'Mario', 'Rossi', 0, 'MROPLD01R09N456H', 'via dei piccioni', '1', 95123, 'catania', 'Italia', 'IT', '3801856222');


INSERT INTO products (id, name, short_desc, image_path, brand_image_path, details, category, product_number, price, quantity, rating) VALUES
(1, 'VARTA B20 Batteria', '12V 4Ah 55, 50A B0 Batteria AGM', 'assets/products/varta_b20.png', 'assets/products/varta_logo.png', '{\"Serie\":\"B20\",\n\"Linea di prodotti\":\"VARTA BLACK dynamic\",\n\"Capacità batteria [Ah]\":\"Batteria 45ah\",\n\"Batteria\":\"Accumulatore piombo-acido\",\n\"Disposizione polare\":\"1\",\n\"Tipo listello di fondo\":\"B13\",\n\"Corrente prova a freddo EN [A]\":\"400\",\n\"Lunghezza [mm]\":\"207\",\n\"Larghezza [mm]\":\"175\",\n\"Altezza [mm]\":\"190\"}', 'Impianto elettrico', '0 986 FA1 000\r\n', 68.09, 10, 3),
(2, 'BOSCH 12V 4AH 55A Batteria', '12V 4Ah 55, 50A B0 Batteria AGM', 'assets/products/batteria_bosch.png', 'assets/products/bosch_logo.png', '{\"Linea di prodotti\":\"BOSCH AGM\",\r\n\"Capacità batteria [Ah]\":\"4\",\r\n\"Batteria\":\"Batteria AGM\",\r\n\"Tipo listello di fondo\":\"B0\",\r\n\"Corrente prova a freddo EN [A]\":\"55, 50\",\r\n\"Lunghezza [mm]\":\"120\",\r\n\"Larghezza [mm]\":\"70\",\r\n\"Altezza [mm]\":\"92\",\r\n\"Tensione [V]\":\"12\",\r\n\"Tipo polo terminale\":\"A\"}', 'Impianto elettrico', ' 0 986 FA1 000', 21.05, 3, 5),
(3, 'WALSER Regio 29058 Tappetini', 'Tessile, anteriore e posteriore, Quantità: 4, antracite', 'assets/products/tappetini.png', 'assets/products/walser.png', '{\r\n  \"Lato montaggio\": \"WALSER 29058 anteriore e posteriore\",\r\n  \"Quantità\": 4,\r\n  \"Colore\": \"antracite\",\r\n  \"Materiale\": \"Tessile\",\r\n  \"Colore bordi\": \"rosso\",\r\n  \"Unità quantitativa\": \"Serie / Kit\",\r\n  \"Serie\": \"Regio\",\r\n  \"Numero articolo\": 29058,\r\n  \"Il nostro prezzo\": \"13,60 €\",\r\n  \"Produttore\": \"WALSER\"\r\n}\r\n', 'Accessori auto', '29058', 13.61, 5, 4),
(4, 'RIDEX Kit pastiglie freni', 'Assale anteriore, senza contatto segnalazione usura, con lamierino anticigolío, senza accessori\r\n', 'assets/products/pastiglie_freni_320d.png', 'assets/products/ridex.png', '{\r\n  \"Unità quantitativa\": \"Set d\'assale\",\r\n  \"Lato montaggio\": \"Assale anteriore\",\r\n  \"Contatto avvisatore usura\": \"Senza contatto segnalazione usura\",\r\n  \"Altezza 1 [mm]\": 73.70,\r\n  \"Larghezza 1 [mm]\": 164.60,\r\n  \"Spessore 1 [mm]\": 16.00,\r\n  \"Articolo complementare / Info integrativa 2\": \"Con lamierino anticigolío\",\r\n  \"Soddisfa la norma ECE\": \"ECE-R90\",\r\n  \"Numero articolo\": \"402B0538\"\r\n}\r\n', 'Freni', '402B0538', 21.06, 20, 5);


INSERT INTO cart_products (id, cart_id, product_id, amount) VALUES
(61, 68, 4, 1),
(64, 68, 1, 1),
(74, 77, 2, 1);


INSERT INTO vehicle (id, brand, model, version) VALUES
(1, 'Fiat', 'Grande Punto', '1.3 mjt 75cv'),
(3, 'BMW', '3 Coupe (E92) (01.2005 - 12.2013)', '320d xDrive (120kw / 163cv) (09.2008 - 06.2013)');


INSERT INTO compatibility (vehicle_id, parts_id) VALUES
(1, 1),
(3, 3),
(3, 4);


INSERT INTO licence_plates (id_vehicle, licence_plate) VALUES
(1, 'DZ309PG'),
(3, 'AB123CD');

INSERT INTO orders (id, user_id, cart_id, address_id, receipt_url) VALUES
(8, 1, 68, 23, 'https://pay.stripe.com/receipts/payment/CAcaFwoVYWNjdF8xUE5HcXQwMjhMYm5UbG1pKI7KgbMGMganxMgbYxU6LBbHMmFkrEhYFWQ-BzE9xjOkI90a52GSF5fjBEmJt8exwuSQl1MPYrYhI2Xw');



