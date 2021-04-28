<?php

declare(strict_types=1);

namespace App\Helpers\Queries\Procedures;

use Exception;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOStatement;

/**
 * Class OracleProcedure.
 */
abstract class BaseProcedure
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $params;

    /**
     * @var \Closure|PDO
     */
    protected \Closure | PDO $pdo;

    /**
     * OracleProcedure constructor.
     * @param string $name
     * @param array $params
     * @param string $connName
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    public function __construct(string $name, array $params, string $connName = '')
    {
        $this->name = $name;
        $this->setParams($params);
        $this->pdo = DB::connection($connName)->getPdo();
    }

    /**
     * @return BaseProcedure
     * @throws Exception
     */
    public function call(): self
    {
        $statement = $this->pdo->prepare($this->generate());

        $this->bindParams($statement);

        if (! $statement->execute()) {
            throw new Exception('Procedure execution error', 100);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $raw = 'begin '.$this->name.'(';

        $i = 0;
        foreach ($this->params as $paramName => &$param) {
            $raw .= $paramName.' => :'.$paramName;
            $raw .= $i < count($this->params) - 1 ? ', ' : '';
            $i++;
        }

        $raw .= '); end;';

        return $raw;
    }

    /**
     * @param PDOStatement $statement
     * @return void
     */
    public function bindParams(PDOStatement &$statement): void
    {
        foreach ($this->params as $paramName => &$param) {
            $statement->bindParam(":{$paramName}", $param['value'], $param['type'] ?? PDO::PARAM_STR);
        }
    }

    /**
     * @return array
     */
    public function getOutputParams(): array
    {
        return array_filter($this->params, function ($param, $paramName) {
            return isset($param['isOut']) && $param['isOut'] == true;
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param array $params
     * @return void
     */
    abstract protected function setParams(array $params): void;
}
