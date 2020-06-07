USE inkmaster_db;

CREATE TABLE reference_image (
    id_reference_image INT NOT NULL,
    id_appointment INT NOT NULL,
    image MEDIUMBLOB NOT NULL,
    PRIMARY KEY (id_reference_image),
    FOREIGN KEY (id_appointment) REFERENCES appointment(id_appointment)
);