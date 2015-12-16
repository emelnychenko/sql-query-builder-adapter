<?php

namespace MI\SQL\QB;

use MI\SQL\QB\Adapter;

/**
 * @package MI\SQL\QB
 * @subpackage InternalInterface
 * @author Eugen Melnychenko
 */
interface InternalInterface
{
    public function pdo(Adapter $adapter, $dataset);
}
