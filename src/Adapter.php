<?php

namespace MI\SQL\QB;

use MI\SQL\QB\AdapterInterface;

use MI\SQL\QB\Internal;
use MI\SQL\QB\Select;
use MI\SQL\QB\Insert;
use MI\SQL\QB\Update;
use MI\SQL\QB\Delete;
use MI\SQL\QB\Query;

/**
 * @package MI\SQL\QB
 * @subpackage Adapter
 * @author Eugen Melnychenko
 */
class Adapter
    implements AdapterInterface
{
    private $pdo;

    /**
     * @param array $config
     *
     * @return int
     */
    public function __construct(array $config)
    {
        $this->pdo = (new Internal())->pdo($this, $config);
    }

    /**
     * @param sting $column
     *
     * @return \MI\SQL\QB\Select
     */
    public function select()
    {
        $columns = func_get_args();

        return new Select($this, get_object_vars($this), $columns);
    }

    /**
     * @param sting $table
     *
     * @return \MI\SQL\QB\Insert
     */
    public function insert($table)
    {
        return new Insert($this, get_object_vars($this), $table);
    }
    
    /**
     * @param sting $table
     *
     * @return \MI\SQL\QB\Update
     */
    public function update($table)
    {
        return new Update($this, get_object_vars($this), $table);
    }

    /**
     * @return \MI\SQL\QB\Delete
     */
    public function delete()
    {
        return new Delete($this, get_object_vars($this));
    }

    /**
     * @return \MI\SQL\QB\Query
     */
    public function query($query)
    {
        return new Query(get_object_vars($this), $query);
    }
}
