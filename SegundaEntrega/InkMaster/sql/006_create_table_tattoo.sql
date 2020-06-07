USE inkmaster_db;

CREATE TABLE tattoo (
    id_tattoo INT NOT NULL,
    id_appointment INT NOT NULL,
    sector VARCHAR(20) NOT NULL,
    image MEDIUMBLOB NOT NULL,
    txt VARCHAR(200) NOT NULL,
    PRIMARY KEY (id_tattoo),
    FOREIGN KEY (id_appointment) REFERENCES appointment(id_appointment)
);