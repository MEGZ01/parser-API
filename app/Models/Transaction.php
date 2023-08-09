<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'paidAmount',
        'currency',
        'parentEmail',
        'statusCode',
        'paymentDate',
        'parentIdentification',
    ];

    public function client(): BelongsTo
{
    return $this->belongsTo(Client::class, 'parentEmail');
}
}
