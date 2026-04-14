<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'rice_item_id',
        'quantity_kilograms',
        'price_per_kilogram',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'quantity_kilograms' => 'decimal:2',
            'price_per_kilogram' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function riceItem(): BelongsTo
    {
        return $this->belongsTo(RiceItem::class);
    }
}
