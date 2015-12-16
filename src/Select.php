<?php

namespace MI\SQL\QB;

use MI\SQL\QB\SelectInterface;

use MI\SQL\QB\Adapter;
use MI\SQL\QB\Query;

use MI\SQL\QB\Clauses\From      as ClausesFrom;
use MI\SQL\QB\Clauses\Join      as ClausesJoin;
use MI\SQL\QB\Clauses\Where     as ClausesWhere;
use MI\SQL\QB\Clauses\Params    as ClausesParams;
use MI\SQL\QB\Clauses\GroupBy   as ClausesGroupBy;
use MI\SQL\QB\Clauses\Having    as ClausesHaving;
use MI\SQL\QB\Clauses\OrderBy   as ClausesOrderBy;
use MI\SQL\QB\Clauses\Limit     as ClausesLimit;
use MI\SQL\QB\Clauses\Offset    as ClausesOffset;

/**
 * @package MI\SQL\QB
 * @subpackage Select
 * @author Eugen Melnychenko
 */
class Select
    implements SelectInterface
{
    use ClausesFrom;
    use ClausesJoin;
    use ClausesWhere;
    use ClausesParams;
    use ClausesGroupBy;
    use ClausesHaving;
    use ClausesOrderBy;
    use ClausesLimit;
    use ClausesOffset;

    private $pdo;
    private $columns;

    /**
     * @param \MI\SQL\QB\Adapter $adapter
     * @param array $params
     * @param string $columns
     *
     * @return \MI\SQL\QB\Select
     */
    public function __construct(Adapter $adapter, array $params, array $columns)
    {
        $this->pdo = $params["pdo"];
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return \MI\SQL\QB\Query
     */
    public function query()
    {
        $query = '';

        if(!empty($this->columns)) {
            $query .= sprintf("SELECT %s", implode(', ', array_unique($this->columns)));
        } else {
            $query .= "SELECT *";
        }

        $query .= $this->getFrom();
        $query .= $this->getJoin();
        $query .= $this->getWhere();
        $query .= $this->getGroupBy();
        $query .= $this->getHaving();
        $query .= $this->getOrderBy();
        $query .= $this->getLimit();
        $query .= $this->getOffset();

        return new Query(get_object_vars($this), $query, Query::SELECT);
    }
}
