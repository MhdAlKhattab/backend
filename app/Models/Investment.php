<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    use HasFactory;

    protected $table = 'investments';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'plan_name', 'amount', 'return_amount',
     'return_period', 'number_returned', 'total_returned'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
