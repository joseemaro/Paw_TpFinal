# Segunda entrega del trabajo final: INK MASTER

## Guía de Ejecución:
<br>
En primer lugar, podemos mencionar que esta aplicación fue probada en Windows 10 Home, utilizando el siguiente software instalado: wamp server versión 3.2.0 - 64bit: PHP versión 7.3.12, MariaDB versión 10.4.10 y MySQL versión 8.0.18. <br>

### Base de datos
* Clonar el repositorio
* Se debe crear una base de datos sql con el nombre "inkmaster_db".
* Una vez creada se debe ejecutar el código que se encuentra en SegundaEntrega/InkMaster/sql correspondiente a la creación de tablas.
* Crear un archivo config.php (hay un ejemplo para copiar en config.php.example).
* Una vez hecho esto ya tenemos la base de datos junto con todas sus tablas correspondientes.

### Composer y ejecución

* En el directorio raíz del programa ejecutar el código
```
composer install
```

Este comando se va a encargar de administrar, descargar e instalar nuestras dependencias de manera automática. <br>


* Una vez realizado esto en la terminal hay que ingresar:
```
php -S localhost:[port]
```
* Y por último en el navegador ir a
```
localhost:[port]
```

### Avances realizados

* Registrar Usuarios 
* Loguearse
* Consultar sección de preguntas frecuentes
* Trabajando en "responsive web design"
* Trabajo generalizado pensando en todas las vistas posibles que podría tener el proyecto, 
aún no llegamos a incorporar los permisos por completo. Es decir, creamos tanto vista de tatuadores (ejemplo: lista de turnos, poder aceptarlos o rechazarlos) como de usuarios finales.
* Solicitar un turno
