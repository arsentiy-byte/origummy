<?php

declare(strict_types=1);

namespace App\DTO\Category;

use App\DTO\InterfaceDTO;
use Str;

/**
 * Class CategoryDTO.
 */
final class CategoryDTO implements InterfaceDTO
{
    /**
     * @var int|null
     */
    public ?int $categoryID = null;

    /**
     * @var string
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var string
     */
    public string $slug;

    /**
     * @var bool
     */
    public bool $status;

    /**
     * @var bool
     */
    public bool $isDefault;

    /**
     * @var int|null
     */
    public ?int $parentID = null;

    /**
     * @var array
     */
    public array $images = [];

    /**
     * @var array
     */
    public array $deleteImages = [];

    /**
     * @param array $input
     * @return static
     */
    public static function fromArray(array $input): self
    {
        $self = new static();

        $self->categoryID = isset($input['category_id']) ? (int) $input['category_id'] : null;
        $self->title = $input['title'] ?? null;
        $self->description = $input['description'] ?? null;
        $self->slug = Str::slug($input['title'] ?? '');
        $self->status = ! isset($input['status']) || (bool) $input['status'];
        $self->isDefault = ! isset($input['is_default']) || (bool) $input['is_default'];
        $self->parentID = isset($input['parent_id']) ? (int) $input['parent_id'] : null;
        $self->images = $input['images'] ?? [];
        $self->deleteImages = $input['delete_images'] ?? [];

        return $self;
    }

    /**
     * @return array
     */
    public function getCategoryData(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'status' => $this->status,
            'is_default' => $this->isDefault,
            'parent_id' => $this->parentID,
        ];
    }

    /**
     * @return array
     */
    public function getCategoryImages(): array
    {
        return $this->images;
    }

    /**
     * @return array
     */
    public function getCategoryDeleteImages(): array
    {
        return $this->deleteImages;
    }
}
