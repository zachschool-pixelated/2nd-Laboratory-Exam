<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class RiceItem extends Model
{
    protected $fillable = [
        'name',
        'price_per_kilogram',
        'stock_quantity',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price_per_kilogram' => 'decimal:2',
            'stock_quantity' => 'decimal:2',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
