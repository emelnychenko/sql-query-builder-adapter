<?php

namespace MI\SQL\QB;

use MI\SQL\QB\QueryInterface;

/**
 * @package MI\SQL\QB
 * @subpackage Query
 * @author Eugen Melnychenko
 */
class Query
    implements QueryInterface
{
    const SELECT = 'select';
    const INSERT = 'insert';
    const UPDATE = 'update';
    const DELETE = 'delete';

    private $pdo;
    private $query;
    private $params;
    private $mode;

    private $executed;
    private $statement;
    private $exception;

    /**
     * @param array $params
     * @param string $query
     * @param sting $mode
     *
     * @return \MI\SQL\QB\Query
     */
    public function __construct(array $params, $query = "", $mode = null)
    {
        $this->pdo      = $params["pdo"];
        $this->query    = $query;
        $this->params   = !empty($params["params"]) ? $params["params"] : [];
        $this->mode     = $mode;

        $this->execute();

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = false;

        if($this->mode === self::SELECT) {
            if(!empty($this->statement)) {
                $result = $this->statement->fetchAll(\PDO::FETCH_ASSOC|\PDO::FETCH_INTO);
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toObject()
    {
        $result = false;

        if($this->mode === self::SELECT) {
            if(!empty($this->statement)) {
                $result = $this->statement->fetchAll(\PDO::FETCH_CLASS);
            }
        }

        return $result;
    }

    /**
     * @return integer
     */
    public function count()
    {
        $result = false;

        if(!empty($this->statement)) {
            $result = $this->statement->rowCount();
        }

        return $result;
    }

    /**
     * @return \MI\SQL\QB\Query
     */
    private function execute()
    {
        $statement = $this->pdo->prepare($this->query);

        if(!empty($this->params) && is_array($this->params)) {
            foreach ($this->params as $key => $value) {
                $pdoparam = null;

                if(is_numeric($value)) {
                    $pdoparam = \PDO::PARAM_INT;
                } elseif(is_string($value)) {
                    $pdoparam = \PDO::PARAM_STR;
                }

                if(empty($pdoparam)) {
                    $statement->bindValue($key, $value);
                } else {
                    $statement->bindValue($key, $value, $pdoparam);
                }
            }
        }

        $this->executed     = $statement->execute();
        $this->exception    = $statement->errorInfo();
        $this->statement    = $statement;

        if($this->mode === self::INSERT) {
            $this->lastId = $this->pdo->lastInsertId();
        }

        $this->pdo = null;

        return $this;
    }
}
