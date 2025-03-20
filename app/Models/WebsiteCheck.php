<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Website;

class WebsiteCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'status_code',
        'response_time',
        'is_up',
        'error_message',
        'headers',
        'checked_at'
    ];

    protected $casts = [
        'is_up' => 'boolean',
        'headers' => 'array',
        'checked_at' => 'datetime'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
