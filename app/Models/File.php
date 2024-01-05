<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subscriptions():BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscription_file')->withPivot('subscription_id', 'file_id');
    }
}