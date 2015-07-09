<?php
/**
 * Author: Michaël VEROUX
 * Date: 09/07/15
 * Time: 14:06
 */

namespace Mv\Cp\Bdd;

interface MysqlOldInterface
{
    /**
     * @param string $sql
     * @return array
     * @author Michaël VEROUX
     */
    public function multi($sql);

    /**
     * @param string $sql
     * @return array assoc
     * @author Michaël VEROUX
     */
    public function unique($sql);

    /**
     * @param string $sql
     * @return void
     * @author Michaël VEROUX
     */
    public function insert($sql);

    /**
     * @return void
     * @author Michaël VEROUX
     */
    public function logout();
}