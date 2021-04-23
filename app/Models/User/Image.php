<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 *
 * @property int $id
 * @property mixed $foto
 * @property-read mixed $image
 */
final class Image extends Model
{
    /**
     * @var string
     */
    protected $table = 'dbmaster.view_userphoto';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = ['id', 'foto'];

    /**
     * @var string[]
     */
    protected $appends = ['image'];

    /**
     * @return mixed
     */
    public function getImageAttribute(): mixed
    {
        return $this->foto;
    }
}
