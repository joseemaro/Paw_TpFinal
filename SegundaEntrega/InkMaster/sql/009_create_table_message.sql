USE inkmaster_db;

CREATE TABLE message (
    id_message INT NOT NULL,
    email_from VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    txt VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_message)
);