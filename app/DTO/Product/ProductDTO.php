<?php

declare(strict_types=1);

namespace App\DTO\Product;

use App\DTO\InterfaceDTO;
use JetBrains\PhpStorm\Pure;

/**
 * Class ProductDTO.
 */
final class ProductDTO implements InterfaceDTO
{
    /**
     * @var int|null
     */
    public ?int $product_id = null;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string|null
     */
    public ?string $description = null;

    /**
     * @var int
     */
    public int $price;

    /**
     * @var int|null
     */
    public ?int $old_price = null;

    /**
     * @var int|null
     */
    public ?int $count = null;

    /**
     * @var int
     */
    public int $category_id;

    /**
     * @var bool
     */
    public bool $status = true;

    /**
     * @var array
     */
    public array $images = [];

    /**
     * @var array
     */
    public array $relatedProducts = [];

    /**
     * @var array
     */
    public array $promotions = [];

    /**
     * @param array $input
     * @return ProductDTO
     */
    #[Pure]
 public static function fromArray(array $input): self
 {
     $self = new static();

     $self->title = $input['title'];
     $self->description = $input['description'] ?? null;
     $self->price = (int) $input['price'];
     $self->old_price = isset($input['old_price']) ? (int) $input['old_price'] : null;
     $self->count = isset($input['count']) ? (int) $input['count'] : null;
     $self->category_id = (int) $input['category_id'];
     $self->status = ! isset($input['status']) || $input['status'];
     $self->images = $input['images'] ?? [];
     $self->relatedProducts = $input['related_products'] ?? [];
     $self->promotions = $input['promotions'] ?? [];

     return $self;
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
        return $this->images;
    }

    /**
     * @return array
     */
    public function getRelatedProducts(): array
    {
        return $this->relatedProducts;
    }

    /**
     * @return array
     */
    public function getPromotions(): array
    {
        return $this->promotions;
    }
}
