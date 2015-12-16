<?php

namespace MI\SQL\QB\Clauses;

trait GroupBy
{
    private $groupBy;

    /**
     * @param string $groupBy
     */
    public function group($groupBy)
    {
        $this->setGroupBy($groupBy);

        return $this;
    }

    /**
     * @param string $groupBy
     */
    public function groupBy($groupBy)
    {
        $this->setGroupBy($groupBy);

        return $this;
    }

    /**
     * @param string $groupBy
     */
    private function setGroupBy($groupBy)
    {
        if(!empty($groupBy) && is_string($groupBy)) {
            $this->groupBy = $groupBy;
        }

        return;
    }

    /**
     * @return string
     */
    private function getGroupBy()
    {
        $partial = "";

        if(!empty($this->groupBy)) {
            $partial .= sprintf(" GROUP BY %s", $this->groupBy);
        }

        return $partial;
    }
}
