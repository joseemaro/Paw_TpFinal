USE inkmaster_db;

CREATE TABLE calendar_link (
    id_artist VARCHAR(100) NOT NULL,
    link VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_artist),
    FOREIGN KEY (id_artist) REFERENCES artist(id_artist)
);