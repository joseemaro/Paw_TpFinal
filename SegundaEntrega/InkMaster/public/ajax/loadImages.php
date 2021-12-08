<?php
    require_once __DIR__.'/../../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
    $dotenv->load();

    $servername = $_ENV['DB_HOST'].":".$_ENV['DB_PORT'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWD'];
    $dbname = $_ENV['DB_NAME'];

    $conn = new mysqli( $servername, $username, $password, $dbname );
    if( $conn->connect_error ){
        die( "Conexión fallida: ".$conn->connect_error );
    }

    $salida = "";
    $quantity = 6;
    $table = 'tattoo';

    if ( isset( $_POST['val'] ) ) {
        $val = $_POST['val'];
    }
    if ( isset( $_POST['page'] ) ) {
        $page = $_POST['page'];
        $beginning = ( ( $page * $quantity ) - $quantity );
    }

    $sql = "select * from $dbname.$table limit $beginning , $quantity";
    $resultado = $conn->query( $sql );
    session_start();

    if ( $resultado->num_rows > 0 ) {
        while ( $fila = $resultado->fetch_assoc() ) {
            $image = base64_encode($fila['image']);
            $salida.= "
                <img class='myImg' src='data:image/png;base64, ".$image."' alt='".$fila['txt']."'>";
        }
    }


    echo $salida;

    $conn->close();

?>