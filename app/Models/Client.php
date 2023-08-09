<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Model
{
    use HasFactory, Notifiable;
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'email';

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'parentEmail');
    }
    protected $fillable = [
        'balance',
        'currency',
        'email',
        'created_at',
        'pass_id',
    ];

}
