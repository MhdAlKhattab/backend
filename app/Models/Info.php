<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $table = 'infos';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'referral_link','Deposit_balance', 'interest_balance',
                             'total_invest', 'total_deposit', 'total_withdraw',
                            'referral_earning'];

                            
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
