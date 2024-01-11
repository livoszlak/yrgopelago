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

```
