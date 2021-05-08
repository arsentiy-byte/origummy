<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\TableNameGetterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory, TableNameGetterTrait;
}
