<?php

declare(strict_types=1);

namespace App\Handlers\UpdateCategory;

use App\DTO\Category\CategoryDTO;
use App\Handlers\UpdateCategory\Pipes\UpdateCategory;
use App\Handlers\UpdateCategory\Pipes\UpdateCategoryImages;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class UpdateCategoryHandler.
 */
final class UpdateCategoryHandler
{
    /**
     * @var Pipeline
     */
    private Pipeline $pipeline;

    /**
     * UpdateCategoryHandler constructor.
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
        return [
            UpdateCategory::class,
            UpdateCategoryImages::class,
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
