USE inkmaster_db;

CREATE TABLE faq (
    id_faq INT NOT NULL AUTO_INCREMENT,
    question VARCHAR(100) NOT NULL,
    answer VARCHAR(300) NOT NULL,
    summary VARCHAR(300) NOT NULL,
    visits INT NOT NULL,
    PRIMARY KEY (id_faq)
);