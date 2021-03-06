CREATE TABLE inkmaster_db.local (
    id_local SERIAL NOT NULL,
    direction VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    phone VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    txt VARCHAR(500),
    PRIMARY KEY (id_local)
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
    enabled BOOLEAN NOT NULL DEFAULT TRUE,
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
    id_appointment INT NOT NULL AUTO_INCREMENT,
    id_local INT NOT NULL,
    id_user VARCHAR(100) NOT NULL,
    id_artist VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    hour TIME NOT NULL,
    status VARCHAR(100) NOT NULL,
    price DOUBLE,
    link VARCHAR(200),
    id_calendar VARCHAR(100),
    txt VARCHAR(100),
    PRIMARY KEY (id_appointment),
    FOREIGN KEY (id_local) REFERENCES local(id_local),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_artist) REFERENCES artist(id_artist)
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
    id_artist VARCHAR(100) NOT NULL,
    id_appointment INT,
    sector VARCHAR(20) NOT NULL,
    image BYTEA NOT NULL,
    txt VARCHAR(200) NOT NULL,
    PRIMARY KEY (id_tattoo),
    FOREIGN KEY (id_artist) REFERENCES inkmaster_db.artist(id_artist),
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
    visits int not null,
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

CREATE TABLE inkmaster_db.administrator (
    id_administrator VARCHAR(100) NOT NULL,
    id_local INT NOT NULL,
    PRIMARY KEY (id_administrator),
    FOREIGN KEY (id_local) REFERENCES inkmaster_db.local(id_local)
);

CREATE TABLE inkmaster_db.permission (
    id_permission VARCHAR(20) NOT NULL,
    txt VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_permission)
);

CREATE TABLE inkmaster_db.rol (
    id_rol VARCHAR(20) NOT NULL,
    txt VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_rol)
);

CREATE TABLE inkmaster_db.permission_rol (
    id_permission_rol SERIAL NOT NULL,
    id_permission VARCHAR(20) NOT NULL,
    id_rol VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_permission_rol),
    FOREIGN KEY (id_permission) REFERENCES inkmaster_db.permission(id_permission),
    FOREIGN KEY (id_rol) REFERENCES inkmaster_db.rol(id_rol)
);

CREATE TABLE inkmaster_db.rol_user (
    id_rol_user SERIAL NOT NULL,
    id_rol VARCHAR(20) NOT NULL,
    id_user VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_rol_user),
    FOREIGN KEY (id_rol) REFERENCES inkmaster_db.rol(id_rol),
    FOREIGN KEY (id_user) REFERENCES inkmaster_db.user(id_user)
);

CREATE TABLE calendar_link (
    id_artist VARCHAR(100) NOT NULL,
    link VARCHAR(100) NOT NULL,
    PRIMARY KEY (id_artist),
    FOREIGN KEY (id_artist) REFERENCES artist(id_artist)
);

insert into inkmaster_db.local (country, province, direction, phone, email, txt) values
('Argentina', 'Buenos Aires', 'San Martín 498, Luján', '2323433247', 'home@inkmaster.com',
'En INK MASTER desde 2018 nos ocupados de ofrecerles contenido de calidad. Contamos con diseños de todo tipo, incluidos tradicionales, japoneses, retratos, negros y grises, tribales y más.');

insert into inkmaster_db.faq (question, answer, summary) values
('¿Cuánto tiempo tarda un tatuaje en curarse?',
    'El tatuaje es una herida en la piel. El tiempo de cicatrización es diferente en cada caso, siendo lo normal entre dos y cuatro semanas. Los primeros días son fundamentales, por eso te damos un kit de cuidados con los elementos necesarios e instrucciones detalladas.', 'El tiempo que se brindará es aproximada');
