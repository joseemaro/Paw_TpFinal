<?php
	$servername = "127.0.0.1";
    $username = "root";
  	$password = "";
  	$dbname = "inkmaster_db";

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
    	$salida.="<section id='content'>";

    	while ($fila = $resultado->fetch_assoc()) {
    		$salida.="
			<article id='column1'>
			<section id='section-del' itemscope>
			<a href='/view_faq/".$fila['id_faq']."'>
				<p itemprop='name' class='preg'>".$fila['question']."</p>
			</a>
			<p class='answer' itemprop='description'>".$fila['answer']."</p>
    		</section>
			</tbody>";

			$admin= false;
			if (isset($_SESSION["id_user"])) {
				$admin = "select * from inkmaster_db.user as u
				inner join inkmaster_db.administrator as a on (u.id_user = a.id_administrator)
				where a.id_local =1 and a.id_administrator =" . $_SESSION["id_user"] . "
				and u.enabled is true";
			}
			if ($admin){
				$salida.= "<section id='section2-del'>
				<form method='get' id='edit-faq-".$fila['id_faq']."' action='/edit_faq/".$fila['id_faq']."'>
					<input type='hidden' name='id_faq' value=".$fila['id_faq'].">
					<button class ='table-button editBtn' type='submit' form='edit-faq-".$fila['id_faq']."'>Edit</button>
				</form>
	
				<form method='get' id='destroy-faq-".$fila['id_faq']."' action='/del_faq/".$fila['id_faq']."' onSubmit='return confirm('Desea eliminar la pregunta?');'>
					<input type='hidden' name='id_faq' value=".$fila['id_faq'].">
					<button class ='table-button deleteBtn' type='submit' form='destroy-faq-".$fila['id_faq']."'>Delete</button>
				</form>
			</section>
			</article>
			";
			}
		};
		$salida.= "
		</section>";
    }else{
    	$salida.="NO HAY DATOS :(";
    }


    echo $salida;


    $conn->close();



?>