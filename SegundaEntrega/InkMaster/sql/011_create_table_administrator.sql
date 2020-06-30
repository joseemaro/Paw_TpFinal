USE inkmaster_db;

CREATE TABLE administrator (
    id_administrator VARCHAR(100) NOT NULL,
    id_local INT NOT NULL,
    PRIMARY KEY (id_administrator),
    FOREIGN KEY (id_local) REFERENCES local(id_local)
);