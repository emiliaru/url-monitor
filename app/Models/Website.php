<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\WebsiteCheck;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'check_interval',
        'category',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_check_at' => 'datetime',
    ];

    public function checks()
    {
        return $this->hasMany(WebsiteCheck::class);
    }

    public function latestCheck()
    {
        return $this->hasOne(WebsiteCheck::class)->latest();
    }
}
