<?php

/**
 * Author: Michaël VEROUX
 * Date: 09/07/15
 * Time: 13:58
 */

namespace Mv\Cp\Bdd;

/**
 * Usages:
 *          Mysql::create()->multi('SELECT * FROM table');
 *          Mysql::create()->unique('SELECT * FROM table');
 *          Mysql::create()->insert('INSERT INTO table (col1, col2) VALUES ("value1", "value2")');
 *          Mysql::create()->insert('UPDATE table SET col1 = "value1" WHERE col2 = "value2"');
 *
 * or
 *          $mysql = new Mysql();
 * and      $mysql instead of Mysql::create()
 *
 * Class Mysql
 * @package Mv\Cp\Bdd
 * @author Michaël VEROUX
 */
class Mysql implements MysqlOldInterface
{
    /**
     *
     * @var \PDO
     */
    private $pdo;

    /**
     * Mysql constructor.
     */
    public function __construct()
    {
        $dsn = sprintf('mysql:dbname=%s;host=%s', DB_NAME, DB_HOSTNAME);
        $this->pdo = new \PDO($dsn, DB_USER, DB_PASSWORD);
    }

    /**
     * @param string $sql
     * @return array
     * @author Michaël VEROUX
     */
    public function multi($sql)
    {
        $statement = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

        return $statement->fetchAll();
    }

    /**
     * @param string $sql
     * @return array assoc
     * @author Michaël VEROUX
     */
    public function unique($sql)
    {
        $results = $this->multi($sql);

        return reset($results);
    }

    /**
     * @param string $sql
     * @return void
     * @author Michaël VEROUX
     */
    public function insert($sql)
    {
        $this->pdo->query($sql);
    }

    /**
     * @return void
     * @author Michaël VEROUX
     */
    public function logout()
    {
        return;
    }

    /**
     * @param string $string
     * @param int    $type
     *
     * @return string
     * @author Michaël VEROUX
     */
    public function quote($string, $type = \PDO::PARAM_STR) {
        $quoted = $this->pdo->quote($string, $type);

        return $quoted;
    }

    /**
     * @return static
     * @author Michaël VEROUX
     */
    static public function create()
    {
        $mysql = new static();

        return $mysql;
    }
}