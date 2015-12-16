<?php

namespace MI\SQL\QB;

use MI\SQL\QB\UpdateInterface;

use MI\SQL\QB\Adapter;
use MI\SQL\QB\Query;

use MI\SQL\QB\Clauses\Join      as ClausesJoin;
use MI\SQL\QB\Clauses\Where     as ClausesWhere;
use MI\SQL\QB\Clauses\Params    as ClausesParams;
use MI\SQL\QB\Clauses\OrderBy   as ClausesOrderBy;
use MI\SQL\QB\Clauses\Limit     as ClausesLimit;

/**
 * @package MI\SQL\QB
 * @subpackage Update
 * @author Eugen Melnychenko
 */
class Update
    implements UpdateInterface
{
    use ClausesJoin;
    use ClausesWhere;
    use ClausesParams;
    use ClausesOrderBy;
    use ClausesLimit;

    private $pdo;
    private $table;
    private $set;

    /**
     * @param \MI\SQL\QB\Adapter $adapter
     * @param array $params
     * @param string $table
     *
     * @return \MI\SQL\QB\Update
     */
    public function __construct(Adapter $adapter, array $params, $table)
    {
        $this->pdo      = $params["pdo"];
        $this->table    = $table;

        return $this;
    }

    /**
     * @param mixed $set
     * @param string $value
     *
     * @return \MI\SQL\QB\Update
     */
    public function set($set, $value = null)
    {
        $unix = str_replace('.', '', microtime(true));

        if(is_array($set) && !empty($set)) {
            foreach ($set as $skey => $svalue) {
                if(!empty($skey) && !empty($svalue)) {
                    $sunixkey = sprintf("%s_%s", $unix, $skey);

                    $this->set[] = sprintf("%s = :%s", $skey, $sunixkey);
                    $this->params[sprintf(":%s", $sunixkey)] = $svalue;
                }
            }
        } elseif(!is_array($set) && !empty($set) && !empty($value)) {
            $unixset = sprintf("%s_%s", $unix, $set);

            $this->set[] = sprintf("%s = :%s", $set, $unixset);
            $this->params[sprintf(":%s", $unixset)] = $value;
        }


        return $this;
    }

    /**
     * @return \MI\SQL\QB\Query
     */
    public function query()
    {
        $query = "";

        $query .= sprintf("UPDATE %s", $this->table);

        $query .= $this->getJoin();

        if(!empty($this->set)) {
            $query .= sprintf(" SET %s", implode(', ', $this->set));
        }

        $query .= $this->getWhere();
        $query .= $this->getOrderBy();
        $query .= $this->getLimit();

        return new Query(get_object_vars($this), $query, Query::UPDATE);
    }
}
