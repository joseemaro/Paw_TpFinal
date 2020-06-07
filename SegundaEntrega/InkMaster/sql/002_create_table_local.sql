USE inkmaster_db;

CREATE TABLE local (
    id_local INT NOT NULL,
    direction VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    phone VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    txt VARCHAR(300),
    PRIMARY KEY (id_local)
);