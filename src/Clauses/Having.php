<?php

namespace MI\SQL\QB\Clauses;

trait Having
{
    private $having;

    /**
     * @param string $having
     */
    public function having($having)
    {
        $this->setHaving($having);

        return $this;
    }

    /**
     * @param string $having
     */
    private function setHaving($having)
    {
        if(!empty($this->groupBy) && !empty($having) && is_string($having)) {
            $this->having = $having;
        }

        return;
    }

    /**
     * @return string
     */
    private function getHaving()
    {
        $partial = "";

        if(!empty($this->groupBy)
            && !empty($this->having)
        ) {
            $partial .= sprintf(" HAVING %s", $this->groupBy);
        }

        return $partial;
    }
}
