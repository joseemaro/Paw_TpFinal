USE inkmaster_db;

CREATE TABLE user (
    id_user VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    nro_doc VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    direction VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    photo MEDIUMBLOB,
    artist BOOLEAN,
    txt VARCHAR(300),
    PRIMARY KEY (id_user)
);