CREATE TABLE inkmaster_db.local (
    id_local SERIAL NOT NULL,
    direction VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    phone VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    txt VARCHAR(500),
    CONSTRAINT local_pk PRIMARY KEY (id_local)
);

CREATE TABLE inkmaster_db.user (
    id_user VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    born DATE NOT NULL,
    nro_doc VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    direction VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    photo BYTEA,
    PRIMARY KEY (id_user)
);

CREATE TABLE inkmaster_db.artist (
    id_artist VARCHAR(100) NOT NULL,
    id_local INT NOT NULL,
    txt VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_artist),
    FOREIGN KEY (id_artist) REFERENCES inkmaster_db.user(id_user),
    FOREIGN KEY (id_local) REFERENCES inkmaster_db.local(id_local)
);

CREATE TABLE inkmaster_db.appointment (
    id_appointment SERIAL NOT NULL,
    id_local INT NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    id_artist VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    hour TIME NOT NULL,
    status VARCHAR(100) NOT NULL,
    price DOUBLE PRECISION,
    PRIMARY KEY (id_appointment),
    FOREIGN KEY (id_local) REFERENCES inkmaster_db.local(id_local),
    FOREIGN KEY (id_user) REFERENCES inkmaster_db.user(id_user),
    FOREIGN KEY (id_artist) REFERENCES inkmaster_db.artist(id_artist)
);

CREATE TABLE inkmaster_db.reference_image (
    id_reference_image SERIAL NOT NULL,
    id_appointment INT NOT NULL,
    image BYTEA NOT NULL,
    PRIMARY KEY (id_reference_image),
    FOREIGN KEY (id_appointment) REFERENCES inkmaster_db.appointment(id_appointment)
);

CREATE TABLE inkmaster_db.tattoo (
    id_tattoo SERIAL NOT NULL,
    id_appointment INT NOT NULL,
    sector VARCHAR(20) NOT NULL,
    image BYTEA NOT NULL,
    txt VARCHAR(200) NOT NULL,
    PRIMARY KEY (id_tattoo),
    FOREIGN KEY (id_appointment) REFERENCES inkmaster_db.appointment(id_appointment)
);

CREATE TABLE inkmaster_db.medical_record (
    id_medical_record SERIAL NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    considerations VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_medical_record),
    FOREIGN KEY (id_user) REFERENCES inkmaster_db.user(id_user)
);

CREATE TABLE inkmaster_db.faq (
    id_faq SERIAL NOT NULL,
    question VARCHAR(100) NOT NULL,
    answer VARCHAR(300) NOT NULL,
    summary VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_faq)
);

CREATE TABLE inkmaster_db.message (
    id_message SERIAL NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    id_artist VARCHAR(100) NOT NULL,
    txt VARCHAR(300) NOT NULL,
    PRIMARY KEY (id_message),
    FOREIGN KEY (id_user) REFERENCES inkmaster_db.user(id_user),
    FOREIGN KEY (id_artist) REFERENCES inkmaster_db.user(id_user)
);