<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class FoodSale extends Model
{
    protected ?string $table = 'food_sale';

    public bool $timestamps = true;

    protected array $fillable = [
        'id',
        'food_id',
        'stock',
        'sale_date',
        'sale_count',
        'reservation_count',
        'is_deleted',
    ];

    protected array $casts = [
        'id' => 'integer',
        'food_id' => 'integer',
        'stock' => 'integer',
        'sale_count' => 'integer',
        'reservation_count' => 'integer',
        'is_deleted' => 'integer',
    ];
}
