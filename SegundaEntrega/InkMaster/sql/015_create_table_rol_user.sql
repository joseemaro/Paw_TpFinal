USE inkmaster_db;

CREATE TABLE rol_user (
    id_rol_user INT NOT NULL AUTO_INCREMENT,
    id_rol VARCHAR(20) NOT NULL,
    id_user VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_rol_user),
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);