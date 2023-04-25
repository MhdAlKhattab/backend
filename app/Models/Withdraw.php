<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory;

    protected $table = 'withdraws';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'wallet', 'amount', 'method',
                            'charge', 'receivable', 'message', 'state'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
