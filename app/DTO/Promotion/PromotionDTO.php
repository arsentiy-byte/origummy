<?php

declare(strict_types=1);

namespace App\DTO\Promotion;

use App\DTO\InterfaceDTO;
use App\Models\Promotion\PromotionType;

/**
 * Class PromotionDTO.
 */
final class PromotionDTO implements InterfaceDTO
{
    /**
     * @var int|null
     */
    public ?int $promotion_id = null;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var bool
     */
    public bool $status = true;

    /**
     * @var int
     */
    public int $typeId;

    /**
     * @var array
     */
    public array $relatedProducts = [];

    /**
     * @param array $input
     * @return PromotionDTO
     */
    public static function fromArray(array $input): self
    {
        $self = new static();

        $self->title = $input['title'];
        $self->description = $input['description'] ?? null;
        $self->status = ! isset($input['status']) || $input['status'];
        $self->typeId = (int) $input['type_id'];

        $type = PromotionType::findOrfail($self->typeId);
        if ($type->name === PromotionType::NAME_GIFT) {
            $self->relatedProducts = $input['related_products'];
        }

        return $self;
    }

    /**
     * @return array
     */
    public function getPromotionData(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'type_id' => $this->typeId,
        ];
    }

    /**
     * @return array
     */
    public function getRelatedProducts(): array
    {
        return $this->relatedProducts;
    }
}
