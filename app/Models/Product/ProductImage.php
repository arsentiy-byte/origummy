<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\BaseModel;

/**
 * Class ProductImage.
 * @property int $product_id
 * @property string $path
 */
final class ProductImage extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'products_images';

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id', 'path',
    ];
}
