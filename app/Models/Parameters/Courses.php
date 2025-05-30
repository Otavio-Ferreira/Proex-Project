<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['name'];
}
