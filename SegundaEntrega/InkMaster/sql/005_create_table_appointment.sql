USE inkmaster_db;

CREATE TABLE appointment (
    id_appointment INT NOT NULL AUTO_INCREMENT,
    id_local INT NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    id_artist VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    hour TIME NOT NULL,
    status VARCHAR(100) NOT NULL,
    price DOUBLE,
    link VARCHAR(200),
    id_calendar VARCHAR(200),
    PRIMARY KEY (id_appointment),
    FOREIGN KEY (id_local) REFERENCES local(id_local),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_artist) REFERENCES artist(id_artist)
);