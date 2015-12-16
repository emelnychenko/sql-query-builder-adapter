<?php

namespace MI\SQL\QB\Clauses;

trait Join
{
    private $join   = [];

    /**
     * @param string $table
     * @param string $alias
     * @param array $condition
     * @param string $mode
     */
    public function join($table, $alias, array $condition, $mode = "INNER")
    {
        $this->setJoin($table, $alias, $condition, $mode);

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param array $condition
     */
    public function innerJoin($table, $alias, array $condition)
    {
        $this->setJoin($table, $alias, $condition, "INNER");

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param array $condition
     */
    public function leftJoin($table, $alias, array $condition)
    {
        $this->setJoin($table, $alias, $condition, "LEFT");

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param array $condition
     */
    public function rightJoin($table, $alias, array $condition)
    {
        $this->setJoin($table, $alias, $condition, "RIGHT");

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param array $condition
     * @param string $mode
     */
    private function setJoin($table, $alias, array $condition, $mode = "INNER")
    {
        $conditionForm = [];

        if(!empty($condition)) {
            foreach ($condition as $key => $value) {
                $conditionForm[] = sprintf("%s = %s", $key, $value);
            }
        }

        $this->join[] = [
            "table"     => $table,
            "condition" => $conditionForm,
            "alias"     => $alias,
            "mode"      => $mode,
        ];

        return;
    }

    /**
     * @return string
     */
    private function getJoin()
    {
        $partial = "";

        if(!empty($this->join)) {
            foreach ($this->join as $join) {
                $partial .= sprintf(" %s JOIN %s AS %s ON %s",
                    $join["mode"],
                    $join["table"],
                    $join["alias"],
                    implode(' AND ', $join["condition"]));
            }
        }

        return $partial;
    }
}
