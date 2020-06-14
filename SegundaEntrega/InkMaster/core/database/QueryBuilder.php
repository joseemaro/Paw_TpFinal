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
        echo "<br>";
        var_dump($sql);
        echo "<br>";
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
            $statement = $this->pdo->prepare("select count(*) from inkmaster_db.user where id_user = :1 and password = :2");
            $statement->bindValue(':1', $id_user);
            $statement->bindValue(':2', $password);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
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
     * Finds a artist into a table.
     *
     * @param string $table
     */
    public function selectArtists($table) {
        $statement = $this->pdo->prepare("select * from inkmaster_db.$table as u
                                                    inner join artist as a on (u.id_user = a.id_artist);");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    private function sendToLog(Exception $e) {
        if ($this->logger) {
            $this->logger->error('Error', ["Error" => $e]);
        }
    }

    /**
     * Finds a record into a table.
     *
     * @param string $table
     * @param integer $id
     * @return array
     */
    public function find($table, $id)
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
