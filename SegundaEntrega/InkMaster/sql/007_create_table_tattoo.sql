USE inkmaster_db;

CREATE TABLE tattoo (
    id_tattoo INT NOT NULL AUTO_INCREMENT,
    id_artist VARCHAR(100) NOT NULL,
    id_appointment INT,
    sector VARCHAR(20) NOT NULL,
    image MEDIUMBLOB NOT NULL,
    txt VARCHAR(200) NOT NULL,
    PRIMARY KEY (id_tattoo),
    FOREIGN KEY (id_artist) REFERENCES artist(id_artist),
    FOREIGN KEY (id_appointment) REFERENCES appointment(id_appointment)
);