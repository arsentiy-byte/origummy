<?php

declare(strict_types=1);

namespace App\Handlers\CreateCategory;

use App\DTO\Category\CategoryDTO;
use App\Handlers\CreateCategory\Pipes\CreateCategory;
use App\Handlers\CreateCategory\Pipes\CreateCategoryImages;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class CreateCategoryHandler.
 */
final class CreateCategoryHandler
{
    /**
     * @var Pipeline
     */
    private Pipeline $pipeline;

    /**
     * CreateCategoryHandler constructor.
     * @param Pipeline $pipeline
     */
    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * @return array
     */
    public function loadPipes(): array
    {
        return [
            CreateCategory::class,
            CreateCategoryImages::class,
        ];
    }

    /**
     * @param CategoryDTO $categoryDTO
     * @throws Throwable
     */
    public function handle(CategoryDTO $categoryDTO): void
    {
        DB::transaction(function () use ($categoryDTO) {
            $this->pipeline
                ->send($categoryDTO)
                ->through($this->loadPipes())
                ->thenReturn();
        });
    }
}
