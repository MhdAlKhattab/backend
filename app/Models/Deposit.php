<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    use HasFactory;

    protected $table = 'deposits';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id','photo', 'wallet', 'proccess_id'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
