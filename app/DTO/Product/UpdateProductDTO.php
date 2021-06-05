<?php

declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\InterfaceDTO;
use JetBrains\PhpStorm\Pure;

/**
 * Class UpdateProductDTO.
 */
final class UpdateProductDTO implements InterfaceDTO
{
    /**
     * @var int
     */
    public int $product_id;

    /**
     * @var string|null
     */
    public ?string $title = null;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var int|null
     */
    public ?int $price = null;

    /**
     * @var int|null
     */
    public ?int $old_price = null;

    /**
     * @var int|null
     */
    public ?int $count = null;

    /**
     * @var int|null
     */
    public ?int $category_id = null;

    /**
     * @var bool
     */
    public ?bool $status = null;

    /**
     * @var array|null
     */
    public ?array $images = null;

    /**
     * @var array|null
     */
    public ?array $deleteImages = null;

    /**
     * @var array|null
     */
    public ?array $relatedProducts = null;

    /**
     * @var array|null
     */
    public ?array $deleteRelatedProducts = null;

    /**
     * @var array|null
     */
    public ?array $promotions = null;

    /**
     * @var array|null
     */
    public ?array $deletePromotions = null;

    public function __construct(
        int $product_id,
        ?string $title,
        ?string $description,
        ?int $price,
        ?int $old_price,
        ?int $count,
        ?int $category_id,
        ?bool $status,
        ?array $images,
        ?array $deleteImages,
        ?array $relatedProducts,
        ?array $deleteRelatedProducts,
        ?array $promotions,
        ?array $deletePromotions
    ) {
        $this->product_id = $product_id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->old_price = $old_price;
        $this->count = $count;
        $this->category_id = $category_id;
        $this->status = $status;
        $this->images = $images;
        $this->deleteImages = $deleteImages;
        $this->relatedProducts = $relatedProducts;
        $this->deleteRelatedProducts = $deleteRelatedProducts;
        $this->promotions = $promotions;
        $this->deletePromotions = $deletePromotions;
    }

    /**
     * @param array $input
     * @return UpdateProductDTO
     */
    #[Pure]
 public static function fromArray(array $input): self
 {
     return new self(
            $input['product_id'],
            $input['title'] ?? null,
            $input['description'] ?? null,
            isset($input['price']) ? (int) $input['price'] : null,
            isset($input['old_price']) ? (int) $input['old_price'] : null,
            isset($input['count']) ? (int) $input['count'] : null,
            isset($input['category_id']) ? (int) $input['category_id'] : null,
            isset($input['status']) ? (bool) $input['category_id'] : null,
            $input['images'] ?? null,
            $input['delete_images'] ?? null,
            $input['related_products'] ?? null,
            $input['delete_related_products'] ?? null,
            $input['promotions'] ?? null,
            $input['delete_promotions'] ?? null,
        );
 }

    /**
     * @return array
     */
    public function getProductData(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'count' => $this->count,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ];
    }

    /**
     * @return array
     */
    public function getProductImages(): array
    {
        return $this->images ?? [];
    }

    /**
     * @return array
     */
    public function getProductDeleteImages(): array
    {
        return $this->deleteImages ?? [];
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

    /**
     * @return array
     */
    public function getPromotions(): array
    {
        return $this->promotions ?? [];
    }

    /**
     * @return array
     */
    public function getDeletePromotions(): array
    {
        return $this->deletePromotions ?? [];
    }
}
