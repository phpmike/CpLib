<?php

/**
 * Author: Michaël VEROUX
 * Date: 09/07/15
 * Time: 13:58
 */

namespace Mv\Cp\Bdd;

/**
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

}