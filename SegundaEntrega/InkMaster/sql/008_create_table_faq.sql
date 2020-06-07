USE inkmaster_db;

CREATE TABLE faq (
    id_faq INT NOT NULL,
    question VARCHAR(100) NOT NULL,
    answer VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_faq)
);