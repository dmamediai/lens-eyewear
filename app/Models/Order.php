<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'status', 'items',
        'subtotal', 'discount', 'shipping', 'total',
        'coupon_code', 'shipping_address', 'payment_method', 'payment_status', 'notes',
    ];

    protected $casts = [
        'items'            => 'array',
        'shipping_address' => 'array',
        'subtotal'         => 'decimal:2',
        'discount'         => 'decimal:2',
        'shipping'         => 'decimal:2',
        'total'            => 'decimal:2',
    ];

    public static array $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-amber-100 text-amber-700',
            'processing' => 'bg-blue-100 text-blue-700',
            'shipped'    => 'bg-purple-100 text-purple-700',
            'delivered'  => 'bg-green-100 text-green-700',
            'cancelled'  => 'bg-red-100 text-red-700',
            default      => 'bg-slate-100 text-slate-600',
        };
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number ??= 'ORD-' . strtoupper(substr(uniqid(), -6));
        });
    }
}
