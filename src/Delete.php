<?php

namespace MI\SQL\QB;

use MI\SQL\QB\DeleteInterface;

use MI\SQL\QB\Adapter;
use MI\SQL\QB\Query;

use MI\SQL\QB\Clauses\From      as ClausesFrom;
use MI\SQL\QB\Clauses\Join      as ClausesJoin;
use MI\SQL\QB\Clauses\Where     as ClausesWhere;
use MI\SQL\QB\Clauses\Params    as ClausesParams;
use MI\SQL\QB\Clauses\OrderBy   as ClausesOrderBy;
use MI\SQL\QB\Clauses\Limit     as ClausesLimit;

/**
 * @package MI\SQL\QB
 * @subpackage Delete
 * @author Eugen Melnychenko
 */
class Delete
    implements DeleteInterface
{
    use ClausesFrom;
    use ClausesJoin;
    use ClausesWhere;
    use ClausesParams;
    use ClausesOrderBy;
    use ClausesLimit;

    private $pdo;

    /**
     * @param \MI\SQL\QB\Adapter $adapter
     * @param array $params
     *
     * @return \QB\Delete
     */
    public function __construct(Adapter $adapter, array $params)
    {
        $this->pdo = $params["pdo"];

        return $this;
    }

    /**
     * @return \MI\SQL\QB\Query
     */
    public function query()
    {
        $query = "DELETE";

        $query .= $this->getFrom();
        $query .= $this->getJoin();
        $query .= $this->getWhere();
        $query .= $this->getOrderBy();
        $query .= $this->getLimit();

        return new Query(get_object_vars($this), $query, Query::DELETE);
    }
}
