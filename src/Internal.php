<?php

namespace MI\SQL\QB;

use MI\SQL\QB\InternalInterface;

use MI\SQL\QB\Adapter;

/**
 * @package MI\SQL\QB
 * @subpackage Internal
 * @author Eugen Melnychenko
 */
class Internal
    implements InternalInterface
{
    const ADAPTER_MYSQL = "mysql";

    /**
     * @param \MI\SQL\QB\Adapter $adapter
     * @param array $dataset
     *
     * @return \PDO
     */
    public function pdo(Adapter $adapter, $dataset)
    {
        $pdo        = null;
        $adapter    = !empty($dataset["adapter"]) ? $dataset["adapter"] : "mysql";

        switch ($adapter) {
            case static::ADAPTER_MYSQL:
                $pdo = $this->mysql($dataset);
                break;
        }

        return $pdo;
    }

    /**
     * @param array $dataset
     */
    private function mysql($dataset)
    {
        $charset    = !empty($dataset["charset"])   ? $dataset['charset']   : 'utf8';
        $username   = !empty($dataset["username"])  ? $dataset["username"]  : null;
        $password   = !empty($dataset["password"])  ? $dataset["password"]  : null;

        $dsnParams = [
            "host"          => !empty($dataset["host"]) ? $dataset["host"] : null,
            "unix_socket"   => !empty($dataset["unix_socket"]) ? $dataset["unix_socket"] : null,
            "dbname"        => !empty($dataset["dbname"]) ? $dataset["dbname"] : null,
        ];

        $dsn = $this->dsn(static::ADAPTER_MYSQL, $dsnParams);

        $pdo = new \PDO($dsn, $username, $password);

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_PERSISTENT, true);
        $pdo->exec(sprintf("set names %s", $charset));

        return $pdo;
    }

    /**
     * @param array $params
     */
    private function dsn($adapter, $parameters)
    {
        $dsnParams  = [];

        if(!empty($parameters)) {
            foreach ($parameters as $preference => $param) {
                if(!empty($preference) && !empty($param)) {
                    $dsnParams[] = sprintf("%s=%s", $preference, $param);
                }
            }
        }

        $dsn = !empty($dsnParams) ? implode(';', $dsnParams) : "";

        return sprintf("%s:%s", $adapter, $dsn);
    }
}
