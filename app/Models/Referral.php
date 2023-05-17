<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id','user_referral', 'benefit', 'done'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
