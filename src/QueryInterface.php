<?php

namespace MI\SQL\QB;

/**
 * @package MI\SQL\QB
 * @subpackage QueryInterface
 * @author Eugen Melnychenko
 */
interface QueryInterface
{
    public function __construct(array $params, $query = "", $mode = null);
    public function toArray();
    public function toObject();
    public function count();
}
