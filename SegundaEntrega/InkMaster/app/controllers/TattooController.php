<?php

namespace App\Controllers;

use App\models\Appointment;
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
        $this->appointment = new Appointment();
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
                    $variable["success"] = true;
                    return $this->view( 'tattoo/upload.tattoos', $variable );
                } else {
                    $variable["artist"] = $id_user;
                    $variable["errors"] = $array;
                    $variable["success"] = false;
                    return $this->view( 'tattoo/upload.tattoos', $variable );
                }
            }
        }
        return $this->view( 'not_found' );
    }

    public function changeTattoo( $id_tattoo, $action, $id_artist ) {
        $id_tattoo = str_replace( "%20", " ", $id_tattoo );
        $id_artist = ( $id_artist == 'null' ) ? null : str_replace( "%20", " ", $id_artist );
        $id_tattoo = str_replace( "%20", " ", $id_tattoo );
        $tattoos = ( is_null( $id_artist ) ) ? $this->tattoo->listTattoos() : $this->tattoo->listTattoosFindArtist( $id_artist );
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

    public function getTattoos( $page = 1 ) {
        $quantity = 6;

        $beginning = ( ( $page * $quantity ) - $quantity );
        $tattoos = $this->tattoo->getTattoos($beginning, $quantity);
        return json_encode( $tattoos );
    }

}