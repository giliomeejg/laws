<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Law extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'law_url',
        'user_id'
    ];
    use HasFactory;
}
