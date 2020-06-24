<?php

namespace App\Core\Database;

use PDO;
use Exception;

class QueryBuilder {
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo, $logger = null) {
        $this->pdo = $pdo;
        $this->logger = ($logger) ? $logger : null;
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters) {
        $parameters = $this->cleanParameterName($parameters);
        $table = "inkmaster_db." . $table;
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a record into a table.
     *
     * @param string $id_user
     * @param string $password
     * @return integer
     */
    public function autentication($id_user, $password) {
        try {
            $statement = $this->pdo->prepare("select * from inkmaster_db.user where id_user = :1");
            $statement->bindValue(':1', $id_user);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);;
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table) {
        $statement = $this->pdo->prepare("select * from inkmaster_db.{$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Select all artists from a database table.
     *
     * @param string $table
     */
    public function listArtists($table, $id_local) {
        try {
            $statement = $this->pdo->prepare("select * from inkmaster_db.$table as u
                                                    inner join inkmaster_db.artist as a on (u.id_user = a.id_artist)
                                                    where id_local = :1;");
            $statement->bindValue(':1', $id_local);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Select all appointments from a database table.
     *
     * @param string $table
     */
    public function listAppointment($table) {
        $statement = $this->pdo->prepare("select * from inkmaster_db.$table as a
                                                    inner join inkmaster_db.user as u on (a.id_user = u.id_user);");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }


    /**
     * Select  waiting appointments from an artist to acept or anule them
     *
     * @param string $table
     * @param string $id
     */
    public function listWaitingAppointment($table, $id) {
        $sql = "select * from inkmaster_db.$table as turno 
                inner join inkmaster_db.user as usuario on usuario.id_user=turno.id_user
                where turno.id_artist = :id
                and turno.status='pendiente';";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            //var_dump($statement);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }


    /**
     * Acept an appointment, change the status to 'aceptado'
     *
     * @param string $table
     * @param integer $id_appointment
     */
    public function aceptAppointment($table , $id_appointment){
        $statement = $this->pdo->prepare("update inkmaster_db.$table set status='aceptado' WHERE id_appointment= :id ;");
        $statement->bindValue(":id", $id_appointment);
        $statement->execute();
        return null;
    }

    /**
     * anule an appointment, change the status to 'aceptado'
     *
     * @param string $table
     * @param integer $id_appointment
     */
    public function deleteAppointment($table , $id_appointment){
        $statement = $this->pdo->prepare("update inkmaster_db.$table set status='anulado' WHERE id_appointment= :id ;");
        $statement->bindValue(":id", $id_appointment);
        $statement->execute();
        return null;
    }


    /**
     * Finds a local into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function findLocal($table, $id)
    {
        $sql = "select * from inkmaster_db.$table where id_local = :id;";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a faq into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function findFaq($table, $id)
    {
        $sql = "select * from inkmaster_db.$table where id_faq = :id";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a user into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function findUser($table, $id)
    {
        $sql = "select * from inkmaster_db.$table where id_user = :id";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

     /**
        * Recovers images from database table.
        *
        * @param string $table
        * @param integer $beginning
        * @param integer $quantity
        * @return array
        */
     public function getTattoos($table, $beginning, $quantity)
     {
        $sql = "select * from inkmaster_db.$table limit :beginning , :quantity";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":beginning", $beginning);
            $statement->bindValue(":quantity", $quantity);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
     }

     /**
         * Counts the number of tuples in a table
         *
         * @param string $table
         * @return array
         */
     public function countTuples($table)
     {
         $sql = "select count(*) as total from inkmaster_db.$table";
         try {
             $statement = $this->pdo->prepare($sql);
             $statement->execute();
             return $statement->fetch(PDO::FETCH_ASSOC);
         } catch (Exception $e) {
             $this->sendToLog($e);
         }
     }

    /**
     * Finds a user into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function findCantUser($table, $id)
    {
        $sql = "select count(*) as cant from inkmaster_db.$table where id_user = :id";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a artist into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function findArtist($table, $id)
    {
        $sql = "select * from inkmaster_db.$table as u
                inner join inkmaster_db.artist as a on (u.id_user = a.id_artist)
                where id_artist = :id";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a artist into from database table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function existLocal($table, $id)
    {
        $sql = "select * from local where exists (select * from inkmaster_db.$table
                                            where id_local = :id)";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    private function sendToLog(Exception $e) {
        if ($this->logger) {
            $this->logger->error('Error', ["Error" => $e]);
        }
    }

    /**
     * Limpia guiones - que puedan venir en los nombre de los parametros
     * ya que esto no funciona con PDO
     *
     * Ver: http://php.net/manual/en/pdo.prepared-statements.php#97162
     */
    private function cleanParameterName($parameters) {
        $cleaned_params = [];
        foreach ($parameters as $name => $value) {
            $cleaned_params[str_replace('-', '', $name)] = $value ;
        }
        return $cleaned_params;
    }

}
