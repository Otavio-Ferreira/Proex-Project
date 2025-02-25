<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'user_id',
        'type',
        'status'
    ];
}
