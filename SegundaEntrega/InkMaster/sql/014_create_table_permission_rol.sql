USE inkmaster_db;

CREATE TABLE permission_rol (
    id_permission_rol INT NOT NULL AUTO_INCREMENT,
    id_permission VARCHAR(20) NOT NULL,
    id_rol VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_permission_rol),
    FOREIGN KEY (id_permission) REFERENCES permission(id_permission),
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);