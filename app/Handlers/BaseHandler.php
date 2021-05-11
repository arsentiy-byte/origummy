<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTO\InterfaceDTO;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseHandler
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
     * @param InterfaceDTO $dto
     * @throws Throwable
     */
    public function handle(InterfaceDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $this->pipeline
                ->send($dto)
                ->through($this->loadPipes())
                ->thenReturn();
        });
    }
}
