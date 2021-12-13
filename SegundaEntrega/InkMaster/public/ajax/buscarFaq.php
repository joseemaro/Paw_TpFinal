<?php
    require_once __DIR__.'/../../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
    $dotenv->load();

    $servername = $_ENV['DB_HOST'].":".$_ENV['DB_PORT'];
    $username = $_ENV['DB_USER'];
  	$password = $_ENV['DB_PASSWD'];
  	$dbname = $_ENV['DB_NAME'];

	$conn = new mysqli($servername, $username, $password, $dbname);
      if($conn->connect_error){
        die("Conexión fallida: ".$conn->connect_error);
      }

    $salida = "";

    $query = "SELECT * FROM faq";

    if (isset($_POST['val'])) {
		if ($_POST['val'] == 'MorePopular'){
			$query = "SELECT * FROM faq order by visits desc";
		}else if (($_POST['val'] == 'LessPopular')){
        	$query = "SELECT * FROM faq order by visits asc";
		}else if(($_POST['val'] == 'MoreRecent')){
			$query = "SELECT * FROM faq order by id_faq asc";
		}else if(($_POST['val'] == 'LessRecent')){
			$query = "SELECT * FROM faq order by id_faq desc";
		}
    }
    $resultado = $conn->query($query);
	session_start();

    if ($resultado->num_rows>0) {
    	$salida.="<div class='questions__accordions' id='content'>
		";

    	while ($fila = $resultado->fetch_assoc()) {
    		$salida.="
				<div class='question-answer__accordion'>
					<div class='question'>
						<h3 class='title__question'>
							" . $fila['question'] . "
						</h3>
						<img src='/public/images/icon-arrow-down.svg' >
					</div>
					<div class='answer'>
						<p class='answer-block'> " . $fila['answer'] . " </p>
						<p class='answer-block'> " . $fila['summary'] . " </p>
						<p class='answer-block visits'> Total de visitas: " . $fila['visits'] . " </p>";

			$admin= false;
			$aux = false;
			if (isset($_SESSION["id_user"])) {
/* 				$admin = "select * from $dbname.user as u
				inner join $dbname.administrator as a on (u.id_user = a.id_administrator)
				where a.id_local =1 and a.id_administrator =" . $_SESSION["id_user"] . "
				and u.enabled is true"; */
				$admin = "select * from $dbname.administrator as u
				where u.id_administrator ='" . $_SESSION["id_user"] . "'";
				$aux = $conn->query($admin);

			}
			if ($aux){
				if ($aux->num_rows>0){
					$salida.= "
                	<section class='manage-faqs'>
                	    <form method='get' id='edit-faq-" . $fila['id_faq'] . "' action='/edit_faq/" . $fila['id_faq'] . "'>
                	        <input type='hidden' name='id_faq' value=" . $fila['id_faq'] . ">
                	        <button class='table-button editBtn' type='submit' form='edit-faq-" . $fila['id_faq'] . "'>Editar</button>
                	    </form>
					
                	    <form method='get' id='destroy-faq-" . $fila['id_faq'] . "' action='/del_faq/" . $fila['id_faq'] . "' onSubmit='return confirm('Desea eliminar la pregunta?');'>
                	        <input type='hidden' name='id_faq' value=" . $fila['id_faq'] . ">
                	        <button class='table-button deleteBtn' type='submit' form='destroy-faq-" . $fila['id_faq'] . "'>Borrar</button>
                	    </form>
                	</section>";
				}
			}
			$salida.= "
			</div>
			</div>
			";
		};
		$salida.= "
		</div>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;


    $conn->close();



?>