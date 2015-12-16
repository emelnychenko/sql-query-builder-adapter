<?php

namespace MI\SQL\QB\Clauses;

trait Offset
{
    private $offset;

    /**
     * @param integer $number
     */
    public function offset($number)
    {
        if(!empty($this->limit)
            && !empty($number)
            && is_numeric($number)
        ) {
            $this->offset = $number;
        }

        return $this;
    }

    private function getOffset()
    {
        $partial = "";

        if(!empty($this->limit)
            && !empty($this->offset)
        ) {
            $partial .= sprintf(" OFFSET %s", $this->offset);
        }

        return $partial;
    }
}
