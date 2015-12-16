<?php

namespace MI\SQL\QB;

use MI\SQL\QB\Adapter;

/**
 * @package MI\SQL\QB
 * @subpackage UpdateInterface
 * @author Eugen Melnychenko
 */
interface UpdateInterface
{
    public function __construct(Adapter $adapter, array $params, $table);
    public function join($table, $alias, array $condition, $mode = "INNER");
    public function innerJoin($table, $alias, array $condition);
    public function leftJoin($table, $alias, array $condition);
    public function rightJoin($table, $alias, array $condition);
    public function set($set, $value = null);
    public function where($where, $value = null);
    public function andWhere($where, $value = null);
    public function param($params, $value = null);
    public function andParam($params, $value = null);
    public function limit($number);
    public function query();
}
