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

    protected $database = DB_NAME;

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
        $table = "$this->database." . $table;
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
     * delete
     *
     * @param string $table
     * @param integer $id
     *
     */
    public function deleteFromID( $table, $id, $where_id ){

        $sql = "DELETE from $this->database.$table " . $where_id;
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);

            return $statement->execute();
        } catch (Exception $e) {
            return false;
            $this->sendToLog($e);
        }
    }

    /**
     * Finds a record into a table.
     *
     * @param string $id_user
     * @return integer
     */
    public function autentication($id_user) {
        try {
            $statement = $this->pdo->prepare("select * from $this->database.user where id_user = :1");
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
        $statement = $this->pdo->prepare("select * from $this->database.{$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * update medical record
     * @param string $table
     * @param string $id_user
     * @param string $medical
     */
     public function updMedRec($table, $id_user, $medical){
         try {
             $statement = $this->pdo->prepare("update $this->database.$table SET considerations = :2                            
                                                    where id_user = :1;");
             $statement->bindValue(':1', $id_user);
             $statement->bindValue(':2', $medical);
             $statement->execute();
             return null;
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
         //VER ESTO no estamos utilizando el bind porque me pone comillas y no funciona
        $sql = "select * from $this->database.$table limit :beginning , :quantity";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":beginning", $beginning, PDO::PARAM_INT);
            $statement->bindValue(":quantity", $quantity, PDO::PARAM_INT);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
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
        $sql = "select count(*) as total from $this->database.$table";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Counts the number of tuples in a table
     *
     * @param string $sql
     * @param array $parameters
     * @return array
     */
    public function simpleQuery($sql, $parameters = null)
    {
        try {
            $statement = $this->pdo->prepare($sql);
            if (!is_null($parameters)) {
                for ($i = 1; $i < count($parameters)+1; $i++) {
                    $statement->bindValue(":$i", $parameters[$i-1]);
                }
            }
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Counts the number of tuples in a table
     *
     * @param string $sql
     * @param array $parameters
     * @return array
     */
    public function query($sql, $parameters = null)
    {
        try {
            $statement = $this->pdo->prepare($sql);
            if (!is_null($parameters)) {
                for ($i = 1; $i < count($parameters)+1; $i++) {
                    $statement->bindValue(":$i", $parameters[$i-1]);
                }
            }
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * Insert a record into a table.
     *
     * @param string $sql
     * @param array $parameters
     * @return boolean
     */
    public function update($sql, $parameters)
    {
        try {
            $statement = $this->pdo->prepare($sql);
            if (!is_null($parameters)) {
                for ($i = 1; $i < count($parameters)+1; $i++) {
                    $statement->bindValue(":$i", $parameters[$i-1]);
                }
            }
            $statement->execute();
            return true;
        } catch (Exception $e) {
            return false;
            $this->sendToLog($e);
        }
    }

    /**
     * Insert a record into a table.
     *
     * @param string $table
     * @param $id
     * @param array $parameters
     */
    public function genericUpdate($table, $id, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $sql = sprintf(
                "UPDATE %s SET %s=%s WHERE id=%s;",
                $table,
                $key,
                ':'.$key,
                $id
            );
            try {
                $statement = $this->pdo->prepare($sql);
                $statement->execute(array($key => $value));
            } catch (Exception $e) {
                $this->sendToLog($e);
            }
        }
    }

        /**
     * update a record into user table.
     *
     * @param string $table
     * @param $id
     * @param array $parameters
     */
    public function userUpdate($table, $id, $parameters)
    {
        foreach ($parameters as $key => $value) {
            $sql = sprintf(
                "UPDATE %s SET %s=%s WHERE id_user='%s';",
                $table,
                $key,
                ':'.$key,
                $id
            );
            try {
                $statement = $this->pdo->prepare($sql);
                $statement->execute(array($key => $value));
            } catch (Exception $e) {
                $this->sendToLog($e);
            }
        }
    }

    /**
     * delete a faq
     *
     * @param string $table
     * @param integer $id
     *
     */
    public function delFaq($table, $id){

        $sql = "DELETE from $this->database.$table
                                            where id_faq = :id";
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(":id", $id);

            $statement->execute();
            return null;
        } catch (Exception $e) {
            $this->sendToLog($e);
        }
    }

    /**
     * update a faq
     *
     * @param string $table
     * @param integer $id
     * @param array $parameters
     *
     */
    public function updFaq($table, $id, $parameters){

        foreach ($parameters as $key => $value) {
            $sql = sprintf(
                "UPDATE %s SET %s=%s WHERE id_faq=%s;",
                $table,
                $key,
                ':'.$key,
                $id
            );
            try {
                $statement = $this->pdo->prepare($sql);

                $statement->execute(array($key => $value));
                return null;
            } catch (Exception $e) {
                $this->sendToLog($e);
            }
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
