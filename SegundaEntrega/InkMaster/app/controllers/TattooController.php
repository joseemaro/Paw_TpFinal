<?php

namespace App\Controllers;

use App\Controllers\GeneralController;
use App\models\Local;
use App\models\Tattoo;
use App\models\User;
use App\Core\App;

class TattooController extends GeneralController
{
    public function __construct()
    {
        $this->user = new User();
        $this->tattoo = new Tattoo();
        $this->local = new Local();
        $this->id_local = $this->local->getLocal();
        $this->session = false;
        $this->logger = App::get('logger');
    }

    public function ulTattoos() {
        session_start();
        if ( isset( $_SESSION["id_user"] ) ) {
            $id_user = $_SESSION["id_user"];
            if ( $this->user->havePermissions( $id_user, 'tattoo.new' ) ) {
                $variable["artist"] = $id_user;
                return $this->view( 'tattoo/upload.tattoos', $variable );
            }
        }
        return $this->view( 'not_found' );
    }

    public function saveTattoo() {
        session_start();
        if ( isset( $_SESSION["id_user"] ) ) {
            $id_user = $_SESSION["id_user"];
            if ( $this->user->havePermissions( $id_user, 'tattoo.new' ) ) {
                $parameters = $this->parameters();
                if ( $parameters ) {
                    $array = $this->tattoo->validateInsert( $parameters );
                } else {
                    $array = ["No se completaron todos los campos obligatorios", false];
                }
                $status = $array[count($array)-1];
                if ( $status ) {  #si salio bien la validacion
                    $variable["artist"] = $id_user;
                    return $this->view( 'tattoo/upload.tattoos', $variable );
                } else {
                    $variable["errors"] = $array;
                    return $this->view( 'errors.register', $variable );
                }
            }
        }
        return $this->view( 'not_found' );
    }

    public function changeTattoo( $id_tattoo, $action ) {
        $id_tattoo = str_replace( "%20", " ", $id_tattoo );
        $id_artist = ( ! empty( $_GET['id_artist'] ) ) ? str_replace( "%20", " ", $_GET['id_artist'] ) : null;
        $id_tattoo = str_replace( "%20", " ", $id_tattoo );
        $tattoos = ( empty( ( $_GET["id_artist"] ) ) ) ? $this->tattoo->listTattoos() : $this->tattoo->listTattoosFindArtist( $id_artist );
        $i = 0;
        $found = false;
        while ( $found == false ) {
            $tattoo = $tattoos[$i];
            if ( $tattoo["id_tattoo"] == $id_tattoo ) {

                $found = true;
                if ( $action == "next" ) {
                    $tattoo = ( $i + 1 >= count( $tattoos ) ) ? $tattoos[0] : $tattoos[$i+1];
                } else {
                    $tattoo = ( $i - 1 < 0 ) ? $tattoos[count( $tattoos ) - 1] : $tattoos[$i-1];
                }
                $tattoo["image"] = base64_encode( $tattoo["image"] );
            }
            if ( $action == "next" ) {
                $i++;
                if ( $i >= count( $tattoos ) ) {
                    $i = 0;
                }
            } else {
                $i--;
                if ( $i < 0 ) {
                    $i = count( $tattoos ) - 1;
                }
            }
        }
        return json_encode( $tattoo );
    }

    public function delTattoo( $id_tattoo ) {
        $id_tattoo = str_replace( "%20", " ", $id_tattoo );
        session_start();
        if ( isset( $_SESSION["id_user"] ) ) {
            $id_user = $_SESSION["id_user"];
            if ( $this->user->havePermissions( $id_user, 'tattoo.delete' ) ) {
                if ( $this->isArtist( $id_user ) && $this->tattoo->verifyArtist( $id_tattoo, $id_user ) ) {
                    $status = $this->tattoo->deleteTattoo( $id_tattoo );
                    $variable["artist"] = $this->user->findArtist( $id_user );
                    if ($status != false) {  #si salio bien la validacion
                        return $this->view("artist/view.artist", $variable);
                    }
                }
            }
        }
        return $this->view('not_found');
    }

    public function listTattoos() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $quantity = 6; //Cant de fotos por pág
        $beginning = ($page > 1) ? (($page * $quantity) - $quantity) : 0;
        $totalTattoos = $this->tattoo->countTattoos();
        if ($totalTattoos > 0) {
            if ($totalTattoos > $quantity) {
                $variable["total_pages"] = ceil($totalTattoos['total'] / $quantity);
                $variable["page"] = $page;
            }
            $variable["tattoos"] = $this->tattoo->getTattoos($beginning, $quantity);
            return $this->view('tattoo/list.tattoos', $variable);
        } else {
            session_start();
            if (isset($_SESSION["id_user"])) {
                $id_user = $_SESSION["id_user"];
                if ($this->generalController->user->havePermissions($id_user, 'tattoo.new')) {
                    return $this->view('tattoo/upload.tattoos');
                }
            }
        }
        return $this->view('tattoo/list.tattoos');
    }

    public function getTattoos() {
        $salida = "";
        $quantity = 6;

        if ( isset( $_POST['val'] ) ) {
            $val = $_POST['val'];
        }
        if ( isset( $_POST['page'] ) ) {
            $page = $_POST['page'];
            $beginning = ( ( $page * $quantity ) - $quantity );
        }
        $tattoos = $this->tattoo->getTattoos($beginning, $quantity);
        if ( count( $tattoos ) > 0 ) {
            foreach ( $tattoos as $tattoo ) {
                $salida.= "<img class='myImg' src='data:image/png;base64, ".$tattoo["image"]."' alt='".$tattoo["txt"]."' data-tattoo-id='".$tattoo['id_tattoo']."'>";
            }
        }
        return $salida;
    }

}