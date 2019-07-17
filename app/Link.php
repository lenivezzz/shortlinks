<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'short_uri',
        'full_url',
        'expires_at',
    ];
}
