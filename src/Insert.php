<?php

namespace MI\SQL\QB;

use MI\SQL\QB\InsertInterface;

use MI\SQL\QB\Adapter;
use MI\SQL\QB\Query;

use MI\SQL\QB\Clauses\Params as ClausesParams;

/**
* @package MI\SQL\QB
* @subpackage Insert
* @author Eugen Melnychenko
*/
class Insert
implements InsertInterface
{
    use ClausesParams;
    
    private $pdo;
    private $table;
    private $colums;
    
    /**
    * @param \MI\SQL\QB\Adapter $adapter
    * @param array $params
    * @param string $table
    *
    * @return \MI\SQL\QB\Insert
    */
    public function __construct(Adapter $adapter, array $params, $table)
    {
        $this->pdo      = $params["pdo"];
        $this->table    = $table;
        
        return $this;
    }
    
    /**
    * @param mixed $column
    * @param string $value
    *
    * @return \MI\SQL\QB\Insert
    */
    public function values($column, $value = null)
    {
        $unix = str_replace('.', '', microtime(true));
        
        if(is_array($column) && !empty($column)) {
            foreach ($column as $ckey => $cvalue) {
                if(!empty($ckey) && !empty($cvalue)) {
                    $cunixkey = sprintf("%s_%s", $unix, $ckey);
                    
                    $this->colums[sprintf(":%s", $cunixkey)] = $ckey;
                    $this->params[sprintf(":%s", $cunixkey)] = $cvalue;
                }
            }
        } elseif(!is_array($column) && !empty($column) && !empty($value)) {
            $unixcolumn = sprintf("%s_%s", $unix, $column);
            
            $this->colums[sprintf(":%s", $unixcolumn)] = $column;
            $this->params[sprintf(":%s", $unixcolumn)] = $value;
        }
        
        return $this;
    }
    
    /**
    * @return \MI\SQL\QB\Query
    */
    public function query()
    {
        $query = '';
        
        $query .= sprintf("INSERT INTO %s", $this->table);
        
        if(!empty($this->colums) && is_array($this->colums)) {
            $datacolumns    = [];
            $dataparams     = [];
            
            foreach ($this->colums as $param => $column) {
                $datacolumns[]  = $column;
                $dataparams[]   = $param;
            }
            
            $query .= sprintf(" (%s)", implode(', ', $datacolumns));
            $query .= sprintf(" VALUES (%s)", implode(', ', $dataparams));
        }
        
        return new Query(get_object_vars($this), $query, Query::INSERT);
    }
}
