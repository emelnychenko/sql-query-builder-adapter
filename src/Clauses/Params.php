<?php

namespace MI\SQL\QB\Clauses;

trait Params
{
    private $params = [];

    /**
     * @param mixed $params
     * @param string $value
     */
    public function param($params, $value = null)
    {
        $this->setParam($params, $value);

        return $this;
    }

    /**
     * @param mixed $params
     * @param string $value
     */
    public function andParam($params, $value = null)
    {
        $this->setParam($params, $value);

        return $this;
    }

    /**
     * @param mixed $params
     * @param string $value
     */
    private function setParam($params, $value = null)
    {
        if(is_array($params) && !empty($params)) {
            foreach ($params as $pkey => $pvalue) {
                $this->params[sprintf(":%s", $pkey)] = $pvalue;
            }
        } elseif(!is_array($params) && !empty($params) && !empty($value)) {
            $this->params[sprintf(":%s", $params)] = $value;
        }

        return;
    }
}
