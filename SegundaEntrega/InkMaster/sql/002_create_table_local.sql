USE inkmaster_db;

CREATE TABLE local (
    id_local INT NOT NULL AUTO_INCREMENT,
    direction VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    phone VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    txt VARCHAR(500),
    PRIMARY KEY (id_local)
);