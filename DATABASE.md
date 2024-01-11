## The Cat's Cradle database structure

#### **Tables**

```sql
CREATE TABLE hotel
(id INTEGER PRIMARY KEY,
island VARCHAR,
hotel VARCHAR,
stars INTEGER
);

CREATE TABLE rooms (
id INTEGER PRIMARY KEY,
room_type VARCHAR,
room_price INT
);


CREATE TABLE features (
id INTEGER PRIMARY KEY,
feature_name VARCHAR,
feature_description VARCHAR
);


CREATE TABLE room_feature (
id INTEGER PRIMARY KEY,
room_id INTEGER,
feature_id INTEGER,
feature_price INTEGER,
feature_name VARCHAR,
feature_url VARCHAR,
FOREIGN KEY (room_id) REFERENCES rooms(id),
FOREIGN KEY (feature_id) REFERENCES features(id)
);

CREATE TABLE bookings (
id INTEGER PRIMARY KEY,
hotel_id INTEGER,
guest_id VARCHAR,
room_id INTEGER,
arrival_date DATE,
departure_date DATE,
total_cost FLOAT,
transfer_code VARCHAR,
greeting VARCHAR,
FOREIGN KEY (hotel_id) REFERENCES hotel(id),
FOREIGN KEY (guest_id) REFERENCES guests(id),
FOREIGN KEY (room_id) REFERENCES rooms(id)
);

CREATE TABLE room_availability (
room_id INTEGER,
date DATE,
is_available BOOLEAN,
PRIMARY KEY(room_id, date),
FOREIGN KEY (room_id) REFERENCES rooms(id));

CREATE TABLE reservations (
id INTEGER PRIMARY KEY,
guest_id VARCHAR,
room_id INTEGER,
date DATE,
time INTEGER,
FOREIGN KEY (room_id) REFERENCES rooms(id)
);

CREATE TABLE booking_feature (
id INTEGER PRIMARY KEY,
feature_id INTEGER,
feature_price INTEGER,
booking_id INTEGER,
FOREIGN KEY (feature_id) REFERENCES room_feature(id),
FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

```

#### ** Inserts ** 

``` sql
INSERT INTO hotel (hotel_name, hotel_address, stars)
VALUES ("The Cat's Cradle", "200 Meowington Lane, Isle of Cats", 1);

INSERT INTO features (feature_name, feature_description)
VALUES 
    ('Persian Cat', 'Persian cats are known for their luxurious long fur and distinctive flat faces'),
    ('Siamese Cat', 'Siamese cats are recognized for their striking blue almond-shaped eyes and color-pointed fur'),
    ('Maine Coon', 'The Maine Coon is a large, friendly cat with tufted ears and a thick, water-resistant coat'),
    ('Bengal Cat', 'Bengal cats have a distinctive spotted or marbled coat that resembles that of a wild leopard'),
    ('Siberian Cat', 'Siberian cats are known for their thick, triple-layered fur and large, round eyes'),
    ('Ragdoll Cat', 'Ragdolls are large, docile cats with striking blue eyes and semi-longhair coats'),
    ('Scottish Fold', 'Scottish Folds are recognized by their unique folded ears, giving them an owl-like appearance'),
    ('Norwegian Forest Cat', 'Norwegian Forest Cats have a thick, bushy tail and a semi-longhair coat adapted for cold climates'),
    ('British Shorthair', 'British Shorthairs are known for their round faces, dense coats, and large, round eyes'),
    ('Abyssinian Cat', 'Abyssinians have a short, ticked coat and are known for their playful and active nature'),
    ('Oriental Shorthair', 'Oriental Shorthairs have a sleek, slender build and come in a variety of coat colors'),
    ('Egyptian Mau', 'The Egyptian Mau is distinguished by its spots and is one of the few naturally spotted breeds'),
    ('Balinese Cat', 'Balinese cats have a long, silky coat and striking blue almond-shaped eyes, similar to the Siamese'),
    ('Russian Blue', 'Russian Blues are known for their short, dense blue-gray coat and vivid green eyes'),
    ('Himalayan Cat', 'Himalayans have a color-pointed coat similar to the Siamese and a Persian-like face'),
    ('Turkish Angora', 'Turkish Angoras have a long, silky coat and are known for their playful and social nature'),
    ('Sphynx Cat', 'The Sphynx is a hairless cat breed known for its wrinkled skin and large ears'),
    ('Burmese Cat', 'Burmese cats have a sleek, shiny coat and captivating, expressive eyes'),
    ('Devon Rex', 'Devon Rex cats have a distinctive curly coat and large, wide-set ears'),
    ('Cornish Rex', 'Cornish Rex cats have a short, wavy coat and a slender, elegant build')
    ;

INSERT INTO rooms (room_type, room_price)
VALUES ("Budget", 1),
("Standard", 2),
("Luxury", 3);

INSERT INTO room_availability (room_id, date, is_available)
VALUES
    (1, '2024-01-01', 1),
    (1, '2024-01-02', 1),
    (1, '2024-01-03', 1),
    (1, '2024-01-04', 1),
    (1, '2024-01-05', 1),
    (1, '2024-01-06', 1),
    (1, '2024-01-07', 1),
    (1, '2024-01-08', 1),
    (1, '2024-01-09', 1),
    (1, '2024-01-10', 1),
    (1, '2024-01-11', 1),
    (1, '2024-01-12', 1),
    (1, '2024-01-13', 1),
    (1, '2024-01-14', 1),
    (1, '2024-01-15', 1),
    (1, '2024-01-16', 1),
    (1, '2024-01-17', 1),
    (1, '2024-01-18', 1),
    (1, '2024-01-19', 1),
    (1, '2024-01-20', 1),
    (1, '2024-01-21', 1),
    (1, '2024-01-22', 1),
    (1, '2024-01-23', 1),
    (1, '2024-01-24', 1),
    (1, '2024-01-25', 1),
    (1, '2024-01-26', 1),
    (1, '2024-01-27', 1),
    (1, '2024-01-28', 1),
    (1, '2024-01-29', 1),
    (1, '2024-01-30', 1),
    (1, '2024-01-31', 1);

INSERT INTO room_availability (room_id, date, is_available)
VALUES
    (2, '2024-01-01', 1),
    (2, '2024-01-02', 1),
    (2, '2024-01-03', 1),
    (2, '2024-01-04', 1),
    (2, '2024-01-05', 1),
    (2, '2024-01-06', 1),
    (2, '2024-01-07', 1),
    (2, '2024-01-08', 1),
    (2, '2024-01-09', 1),
    (2, '2024-01-10', 1),
    (2, '2024-01-11', 1),
    (2, '2024-01-12', 1),
    (2, '2024-01-13', 1),
    (2, '2024-01-14', 1),
    (2, '2024-01-15', 1),
    (2, '2024-01-16', 1),
    (2, '2024-01-17', 1),
    (2, '2024-01-18', 1),
    (2, '2024-01-19', 1),
    (2, '2024-01-20', 1),
    (2, '2024-01-21', 1),
    (2, '2024-01-22', 1),
    (2, '2024-01-23', 1),
    (2, '2024-01-24', 1),
    (2, '2024-01-25', 1),
    (2, '2024-01-26', 1),
    (2, '2024-01-27', 1),
    (2, '2024-01-28', 1),
    (2, '2024-01-29', 1),
    (2, '2024-01-30', 1),
    (2, '2024-01-31', 1);

INSERT INTO room_availability (room_id, date, is_available)
VALUES
    (3, '2024-01-01', 1),
    (3, '2024-01-02', 1),
    (3, '2024-01-03', 1),
    (3, '2024-01-04', 1),
    (3, '2024-01-05', 1),
    (3, '2024-01-06', 1),
    (3, '2024-01-07', 1),
    (3, '2024-01-08', 1),
    (3, '2024-01-09', 1),
    (3, '2024-01-10', 1),
    (3, '2024-01-11', 1),
    (3, '2024-01-12', 1),
    (3, '2024-01-13', 1),
    (3, '2024-01-14', 1),
    (3, '2024-01-15', 1),
    (3, '2024-01-16', 1),
    (3, '2024-01-17', 1),
    (3, '2024-01-18', 1),
    (3, '2024-01-19', 1),
    (3, '2024-01-20', 1),
    (3, '2024-01-21', 1),
    (3, '2024-01-22', 1),
    (3, '2024-01-23', 1),
    (3, '2024-01-24', 1),
    (3, '2024-01-25', 1),
    (3, '2024-01-26', 1),
    (3, '2024-01-27', 1),
    (3, '2024-01-28', 1),
    (3, '2024-01-29', 1),
    (3, '2024-01-30', 1),
    (3, '2024-01-31', 1);

INSERT INTO room_feature (room_id, feature_id, feature_price, feature_name)
VALUES (1, 8, 1, 'Norwegian Forest Cat'),
(1, 12, 1, 'Egyptian Mau'),
(1, 16, 1, 'Turkish Angora'),
(1, 19, 1, 'Devon Rex'),
(1, 20, 1, 'Cornish Rex');

INSERT INTO room_feature (room_id, feature_id, feature_price, feature_name)
VALUES (2, 8, 1, 'Norwegian Forest Cat'),
(2, 12, 1, 'Egyptian Mau'),
(2, 16, 1, 'Turkish Angora'),
(2, 19, 1, 'Devon Rex'),
(2, 20, 1, 'Cornish Rex'),
(2, 10, 2, 'Abyssinian'),
(2, 11, 2, 'Oriental Shorthair'),
(2, 13, 2, 'Balinese'),
(2, 14, 2, 'Russian Blue'),
(2, 17, 2, 'Sphynx');

INSERT INTO room_feature (room_id, feature_id, feature_price, feature_name)
VALUES (3, 8, 1, 'Norwegian Forest Cat'),
(3, 12, 1, 'Egyptian Mau'),
(3, 16, 1, 'Turkish Angora'),
(3, 19, 1, 'Devon Rex'),
(3, 20, 1, 'Cornish Rex'),
(3, 10, 2, 'Abyssinian'),
(3, 11, 2, 'Oriental Shorthair'),
(3, 13, 2, 'Balinese'),
(3, 14, 2, 'Russian Blue'),
(3, 17, 2, 'Sphynx'),
(3, 1, 3, 'Persian'),
(3, 2, 3, 'Siamese'),
(3, 3, 3, 'Maine Coon'),
(3, 4, 3, 'Bengal'),
(3, 5, 3, 'Siberian'),
(3, 6, 3, 'Ragdoll'),
(3, 7, 3, 'Scottish Fold'),
(3, 9, 3, 'British Shorthair'),
(3, 15, 3, 'Himalayan'),
(3, 18, 3, 'Burmese');

INSERT INTO hotel (island, hotel, stars)
VALUES ("Isle of Cats", "The Cat's Cradle", 4);

```
