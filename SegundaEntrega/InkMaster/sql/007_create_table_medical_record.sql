USE inkmaster_db;

CREATE TABLE medical_record (
    id_medical_record INT NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    considerations VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_medical_record),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);