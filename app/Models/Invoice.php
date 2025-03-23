<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_logo',
        'invoice_number',
        'invoice_date',
        'due_date',
        'po_number',
        'bill_to_name',
        'bill_to_address',
        'ship_to_name',
        'ship_to_address',
        'items',
        'subtotal',
        'discount_rate',
        'discount_amount',
        'tax_rate',
        'tax_amount',
        'total',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
