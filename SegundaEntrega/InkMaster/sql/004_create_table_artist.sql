USE inkmaster_db;

CREATE TABLE artist (
    id_artist VARCHAR(100) NOT NULL,
    id_local INT NOT NULL,
    txt VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_artist),
    FOREIGN KEY (id_local) REFERENCES local(id_local)
);