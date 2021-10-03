<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions';

    protected $casts = [
        'expiration_date' => 'datetime:Y-m-d',
    ];

    public function scopeActive($builder)
    {
        return $builder->where('status','=','active');
    }

    public function scopePastExpiry($builder)
    {
        return $builder->whereRaw('subscriptions.expiration_date < CURRENT_DATE');
    }

}
