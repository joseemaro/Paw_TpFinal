insert into inkmaster_db.local (country, province, direction, phone, email, txt) values
('Argentina', 'Buenos Aires', 'San Martín 498, Luján', '2323433247', 'home@inkmaster.com',
'En INK MASTER desde 2018 nos ocupados de ofrecerles contenido de calidad. Contamos con diseños de todo tipo, incluidos tradicionales, japoneses, retratos, negros y grises, tribales y más.');

insert into inkmaster_db.faq (question, answer, summary) values
('¿Cuánto tiempo tarda un tatuaje en curarse?', 'El tatuaje es una herida en la piel. El tiempo de cicatrización es diferente en cada caso, siendo lo normal entre dos y cuatro semanas. Los primeros días son fundamentales, por eso te damos un kit de cuidados con los elementos necesarios e instrucciones detalladas.', 'El tiempo que se brindará es aproximada');

insert into inkmaster_db.calendar_link(id_artist, link) values
    ('numbreTatuador','2kh2fa1hufh640kggiaja7at10@group.calendar.google.com');

insert into `permission` (`id_permission`, `txt`) values
('appointment.acept', 'Confirmar los turnos correspondientes'),
('appointment.edit', 'Editar los turnos correspondientes'),
('appointment.delete', 'Cancelar los turnos correspondientes'),
('user.new', 'Crear un nuevo usuario'),
('user.list', 'Listar usuarios existentes'),
('user.view', 'Visualizar la información perteneciente a un usuario'),
('user.edit', 'Editar la información pertenenciente a un usuario'),
('user.delete', 'Deshabilitar a un usuario'),
('artist.new', 'Crear un nuevo artista'),
('artist.edit', 'Editar la información de un artista'),
('artist.delete', 'Deshabilitar a un artista'),
('tattoo.new', 'Añadir la imagen de un nuevo tattoo'),
('faq.new', 'Crear una nueva pregunta frecuente'),
('faq.edit', 'Editar una pregunta frecuente'),
('faq.delete', 'Eliminar una pregunta frecuente');

insert into `rol` (`id_rol`, `txt`) values
('user', 'Rol de usuario'),
('artist', 'Rol de artista'),
('administrator', 'Rol de administrador');

insert into `permission_rol` (`id_permission_rol`, `id_permission`, `id_rol`) values
(1, 'user.new', 'administrator'),
(2, 'user.list', 'administrator'),
(3, 'user.view', 'administrator'),
(4, 'artist.new', 'administrator'),
(5, 'artist.delete', 'administrator'),
(6, 'faq.new', 'administrator'),
(7, 'faq.edit', 'administrator'),
(8, 'faq.delete', 'administrator'),
(9, 'appointment.acept', 'artist'),
(10, 'appointment.edit', 'artist'),
(11, 'appointment.delete', 'artist'),
(12, 'artist.edit', 'artist'),
(13, 'tattoo.new', 'artist'),
(14, 'user.edit', 'user'),
(15, 'user.delete', 'user'),
(16, 'user.view', 'user');

/*necesario que se cree un usuario con nombre de usuario "Administrador"*/
insert into `administrator` (`id_administrator`, `id_local`) values
('Administrador', 1);

insert into `rol_user` (`id_rol`, `id_user`) values
('user', 'Administrator'),
('administrator', 'Administrator');