<?php

namespace MI\SQL\QB;

use MI\SQL\QB\Adapter;

/**
 * @package MI\SQL\QB
 * @subpackage DeleteInterface
 * @author Eugen Melnychenko
 */
interface DeleteInterface
{
    public function __construct(Adapter $adapter, array $params);
    public function from($table, $alias = null);
    public function join($table, $alias, array $condition, $mode = "INNER");
    public function innerJoin($table, $alias, array $condition);
    public function leftJoin($table, $alias, array $condition);
    public function rightJoin($table, $alias, array $condition);
    public function where($where, $value = null);
    public function andWhere($where, $value = null);
    public function param($params, $value = null);
    public function andParam($params, $value = null);
    public function order($orderBy, $sortMode = "ASC");
    public function orderBy($orderBy, $sortMode = "ASC");
    public function limit($number);
    public function query();
}
