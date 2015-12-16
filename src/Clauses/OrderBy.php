<?php

namespace MI\SQL\QB\Clauses;

trait OrderBy
{
    private $orderBy;

    /**
     * @param string $orderBy
     * @param string $sortMode
     */
    public function order($orderBy, $sortMode = "ASC")
    {
        $this->setOrderBy($orderBy, $sortMode);

        return $this;
    }

    /**
     * @param string $orderBy
     * @param string $sortMode
     */
    public function orderBy($orderBy, $sortMode = "ASC")
    {
        $this->setOrderBy($orderBy, $sortMode);

        return $this;
    }

    /**
     * @param string $orderBy
     * @param string $sortMode
     */
    private function setOrderBy($orderBy, $sortMode = "ASC")
    {
        if(is_array($orderBy)
            && !empty($orderBy)
        ) {
            foreach ($orderBy as $key => $value) {
                if(!is_int($key)
                    && !empty($key)
                    && !empty($value)
                ) {
                    $this->orderBy[] = sprintf("%s %s", $key, $value);
                } elseif(is_int($key) && !empty($value)) {
                    $this->orderBy[] = $value;
                }
            }
        } elseif(!is_array($orderBy)
            && !empty($orderBy)
            && !empty($sortMode)
        ) {
            $this->orderBy[] = sprintf("%s %s", $orderBy, $sortMode);
        } elseif(!is_array($orderBy)
            && !empty($orderBy)
            && empty($sortMode)
        ) {
            $this->orderBy[] = $orderBy;
        }

        return;
    }

    /**
     * @return string
     */
    private function getOrderBy()
    {
        $partial = "";

        if(!empty($this->orderBy)) {
            $partial .= sprintf(" ORDER BY %s", implode(', ', array_unique($this->orderBy)));
        }

        return $partial;
    }
}
