<?php

declare(strict_types=1);

namespace App\Helpers\Queries\Procedures;

use Illuminate\Support\Facades\DB;
use PDO;
use PDOStatement;

/**
 * Class OracleProcedure.
 */
final class OracleProcedure
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $params;

    /**
     * @var \Closure|PDO
     */
    private \Closure | PDO $pdo;

    /**
     * OracleProcedure constructor.
     * @param string $name
     * @param array $params
     * @param string $connName
     */
    public function __construct(string $name, array $params, string $connName = '')
    {
        $this->name = $name;
        $this->params = $params;
        $this->pdo = DB::connection($connName)->getPdo();
    }

    /**
     * @return bool
     */
    public function call(): bool
    {
        $statement = $this->pdo->prepare($this->generate());

        $this->bindParams($statement);

        return $statement->execute();
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
}
