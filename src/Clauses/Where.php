<?php

namespace MI\SQL\QB\Clauses;

trait Where
{
    private $where  = [];

    /**
     * @param mixed $where
     * @param string $value
     */
    public function where($where, $value = null)
    {
        $this->setWhere($where, $value);

        return $this;
    }

    /**
     * @param mixed $where
     * @param string $value
     */
    public function andWhere($where, $value = null)
    {
        $this->setWhere($where, $value);

        return $this;
    }

    /**
     * @param mixed $where
     * @param string $value
     */
    private function setWhere($where, $value = null)
    {
        if(is_array($where) && !empty($where)) {
            foreach ($where as $wkey => $wvalue) {
                if(!is_int($wkey) && !empty($wvalue)) {
                    if((bool) preg_match("/^:/", $wvalue)) {
                        $this->where[] = sprintf("%s = %s", $wkey, $wvalue);
                    } else {
                        $this->where[] = sprintf("%s = '%s'", $wkey, $wvalue);
                    }
                } elseif(is_int($wkey) && !empty($wvalue)) {
                    $this->where[] = $wvalue;
                }
            }
        } elseif(!is_array($where) && !empty($where) && !empty($value)) {
            if((bool) preg_match("/^:/", $value)) {
                $this->where[] = sprintf("%s = %s", $where, $value);
            } else {
                $this->where[] = sprintf("%s = '%s'", $where, $value);
            }
        } elseif(!is_array($where) && !empty($where) && empty($value)) {
            $this->where[] = $where;
        }

        return;
    }

    private function getWhere()
    {
        $partial = "";

        if(!empty($this->where)) {
            $partial = sprintf(" WHERE %s", implode(' AND ', array_unique($this->where)));
        }

        return $partial;
    }
}
