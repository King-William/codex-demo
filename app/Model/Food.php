<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $simple_desc
 * @property string $imgs
 * @property string $price
 * @property string $discount_price
 * @property string $newcomer_price
 * @property string $description
 * @property int $sale_count
 * @property int $sort
 * @property int $sale_status
 * @property int $is_deleted
 */
class Food extends Model
{
    protected ?string $table = 'food';

    public bool $timestamps = true;

    protected array $fillable = [
        'id',
        'name',
        'simple_desc',
        'imgs',
        'price',
        'discount_price',
        'newcomer_price',
        'description',
        'sale_count',
        'sort',
        'sale_status',
        'is_deleted',
    ];

    protected array $casts = [
        'id' => 'integer',
        'sale_count' => 'integer',
        'sort' => 'integer',
        'sale_status' => 'integer',
        'is_deleted' => 'integer',
    ];
}
