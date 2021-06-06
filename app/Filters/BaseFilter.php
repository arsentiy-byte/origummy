<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Str;

/**
 * Class BaseFilter.
 * @psalm-suppress PropertyNotSetInConstructor
 */
abstract class BaseFilter
{
    public const KEYS_TO_BOOL = [
        'status',
    ];

    public const KEYS_TO_INT = [
        'id',
    ];

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * BaseFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        /**
         * @var string $method
         * @var mixed $value
         */
        foreach ($this->request->all() as $method => $value) {
            $methodName = Str::camel($method);
            if (method_exists($this, $methodName)) {
                if (in_array($method, static::KEYS_TO_BOOL, true)) {
                    $value = $this->request->boolean($method);
                }
                if (in_array($method, static::KEYS_TO_INT, true)) {
                    $value = (int) $this->request->get($method);
                }
                $this->{$methodName}($value);
            }
        }

        return $this->builder;
    }
}
