<?php

namespace MI\SQL\QB\Clauses;

trait Limit
{
    private $limit;

    /**
     * @param integer $number
     */
    public function limit($number)
    {
        if(!empty($number)
            && is_numeric($number)
        ) {
            $this->limit = $number;
        }

        return $this;
    }

    private function getLimit()
    {
        $partial = "";

        if(!empty($this->limit)) {
            $partial .= sprintf(" LIMIT %s", $this->limit);
        }

        return $partial;
    }
}
