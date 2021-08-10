<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class column extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function card(): HasMany
    {
        return $this->hasMany(card::class)->orderBy('order');
    }
}
