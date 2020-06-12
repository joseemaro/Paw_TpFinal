USE inkmaster_db;

CREATE TABLE message (
    id_message INT NOT NULL AUTO_INCREMENT,
    id_user VARCHAR(100) NOT NULL,
    id_artist VARCHAR(100) NOT NULL,
    txt VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_message),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_artist) REFERENCES user(id_user)
);