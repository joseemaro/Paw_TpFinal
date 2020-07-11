USE inkmaster_db;

CREATE TABLE calendar_link (
    id_artist VARCHAR(100) NOT NULL,
    link VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_artist)
);