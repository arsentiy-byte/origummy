<?php

declare(strict_types=1);

namespace App\DTO\Promotion;

use App\DTO\InterfaceDTO;
use JetBrains\PhpStorm\Pure;

/**
 * Class UpdatePromotionDTO.
 */
final class UpdatePromotionDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    public int $promotion_id;

    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var bool|null
     */
    public ?bool $status = null;

    /**
     * @var int|null
     */
    public ?int $typeId = null;

    /**
     * @var array|null
     */
    public ?array $relatedProducts = null;

    /**
     * @var array|null
     */
    public ?array $deleteRelatedProducts = null;

    public function __construct(
        int $promotion_id,
        ?string $title,
        ?string $description,
        ?bool $status,
        ?int $typeId,
        ?array $relatedProducts,
        ?array $deleteRelatedProducts,
    ) {
        $this->promotion_id = $promotion_id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->typeId = $typeId;
        $this->relatedProducts = $relatedProducts;
        $this->deleteRelatedProducts = $deleteRelatedProducts;
    }

    /**
     * @param array $input
     * @return UpdatePromotionDTO
     */
    #[Pure]
 public static function fromArray(array $input): self
 {
     return new self(
            $input['promotion_id'],
            $input['title'] ?? null,
            $input['description'] ?? null,
            isset($input['status']) ? (bool) $input['status'] : null,
            isset($input['type_id']) ? (int) $input['type_id'] : null,
            $input['related_products'] ?? null,
            $input['delete_related_products'] ?? null,
        );
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
        return $this->relatedProducts ?? [];
    }

    /**
     * @return array
     */
    public function getDeleteRelatedProducts(): array
    {
        return $this->deleteRelatedProducts ?? [];
    }
}
