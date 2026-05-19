<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'sku',
        'name',
        'description',
        'reference_price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'reference_price' => 'decimal:4',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(PurchaseOrderLine::class);
    }
}
