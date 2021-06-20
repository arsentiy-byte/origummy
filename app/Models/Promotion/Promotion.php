<?php

declare(strict_types=1);

namespace App\Models\Promotion;

use App\Models\BaseModel;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Promotion.
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $status
 * @property int $type_id
 * @property-read Product[] $products
 * @property-read PromotionType $type
 * @property-read Product[] $relatedProducts
 */
final class Promotion extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'description', 'status', 'type_id',
    ];

    /**
     * @return HasManyThrough
     */
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, ProductPromotion::class, 'promotion_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PromotionType::class, 'type_id');
    }

    /**
     * @return HasManyThrough
     */
    public function relatedProducts(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, RelatedPromotion::class, 'promotion_id', 'id', 'id', 'product_id');
    }
}
