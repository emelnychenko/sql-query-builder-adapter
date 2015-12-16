<?php

namespace MI\SQL\QB\Clauses;

trait From
{
    /**
     * @param string $table
     * @param string $alias
     */
    public function from($table, $alias = null)
    {
        $this->setFrom($table, $alias);

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     */
    private function setFrom($table, $alias = null)
    {
        if(!empty($table)) {
            $this->table = $table;

            if(!empty($alias)) {
                $this->alias = $alias;
            }
        }

        return;
    }

    /**
     * @return string
     */
    private function getFrom()
    {
        $partial = "";

        if(!empty($this->table)) {
            $partial .= sprintf(" FROM %s", $this->table);
        }

        if(!empty($this->alias)) {
            $partial .= sprintf(" AS %s", $this->alias);
        }

        return $partial;
    }
}
