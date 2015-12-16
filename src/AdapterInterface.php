<?php

namespace MI\SQL\QB;

/**
 * @package MI\SQL\QB
 * @subpackage AdapterInterface
 * @author Eugen Melnychenko
 */
interface AdapterInterface
{
    public function __construct(array $config);
    public function select();
    public function insert($table);
    public function update($table);
    public function delete();
    public function query($query);
}
