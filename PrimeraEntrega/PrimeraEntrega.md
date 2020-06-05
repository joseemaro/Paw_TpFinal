# Primera entrega del trabajo final: INK MASTER

## Análisis de requerimientos

Tomamos como requisitos funcionales aquellas funciones principales del sistema que "hacen" al mismo. Es decir, un conjunto de entradas, comportamientos y salidas. <br>

* RQ-001
Para un usuario que desea solicitar un turno por primera vez, el sistema le debe permitir registrarse en el mismo. Luego de que genere un usuario y contraseña y complete un formulario con una serie de datos personales, tales como, nombre, apellido, información de contacto, enfermedades crónicas, etc; el sistema persistirá tales datos.
* RQ-002
El sistema debe hacer que la ficha o información del cliente sea editable.
* RQ-003
El sistema debe permitir que un usuario logueado solicite un turno, indicando día, horario, profesional de preferencia y cualquier otro tipo de información relevante (embarazo, por ejemplo). Adjuntando también imágenes de referencia. En consecuencia, se persistirá dicha información y el turno quedará como pendiente ante el usuario solicitante.
* RQ-004
El sistema debe autorizar a un profesional a aceptar o rechazar un turno solicitado y en efecto, informar al cliente el resultado (aprobado, rechazado).
* RQ-005
Solamente los usuarios autorizados (profesionales) podrán visualizar la agenda de turnos ya sea pendientes de aprobación o fijados. También deben poder acceder a la ficha del cliente que se atenderá.
* RQ-006
El sistema debe permitir que un usuario autorizado cancele su turno. Reflejando los cambios en la ficha del mismo.

## Componentes funcionales

Algunos de los componentes que se ponen en marcha como resultado de la interacción del usuario son: <br>

* Consultar lista de turnos general (profesional).
* Consultar lista de turnos pendientes / por aprobar (profesional).
* Aprobar / rechazar solicitudes (profesional)
* Registrarse en el sistema (usuario / cliente).
* Modificar información personal (usuario / cliente).
* Ingresar un nuevo turno (usuario / cliente).
* Dar de baja un turno (usuario / cliente).
* Ver el catálogo de diseños disponibles (usuario / cliente).
* Ver experiencias de otros clientes / trabajos realizados (usuario / cliente).

## Site map

En el siguiente link se pueden observar el site-map del proyecto: <br>

[SiteMap](SiteMap.md)

## Wireframes

En el siguiente link se pueden observar los wireframes de las principales pantallas del proyecto: <br>

[Wireframes](wireframes.md)

## Diagrama de clases

En el siguiente link se puede observar el diagrama de clases incorporando el patrón MVC: <br>

[Clases](Diagramas.md)

## Diseño del modelo de datos

En el siguiente link se puede observar el modelo de datos: <br>

[DER](DER.md)
