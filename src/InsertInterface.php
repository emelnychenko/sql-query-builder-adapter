<?php

namespace MI\SQL\QB;

use MI\SQL\QB\Adapter;

/**
 * @package MI\SQL\QB
 * @subpackage InsertInterface
 * @author Eugen Melnychenko
 */
interface InsertInterface
{
    public function __construct(Adapter $adapter, array $params, $table);
    public function values($column, $value = null);
    public function query();
}
