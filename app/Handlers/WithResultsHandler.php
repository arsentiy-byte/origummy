<?php

declare(strict_types=1);

namespace App\Handlers;

use DB;
use Illuminate\Pipeline\Pipeline;
use Throwable;

/**
 * Class WithResultsHandler.
 */
abstract class WithResultsHandler
{
    public const PIPES = [];

    /**
     * @var Pipeline
     */
    protected Pipeline $pipeline;

    /**
     * DeleteCategoryHandler constructor.
     * @param Pipeline $pipeline
     */
    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * @return string[]
     */
    public function loadPipes(): array
    {
        return static::PIPES;
    }

    /**
     * @param InterfaceParam $param
     * @return array
     * @throws Throwable
     */
    public function handle(InterfaceParam $param): array
    {
        return DB::transaction(function () use ($param) {
            return $this->pipeline
                ->send($param)
                ->through($this->loadPipes())
                ->then(function (InterfaceParam $param) {
                    return $param->getResult();
                });
        });
    }
}
