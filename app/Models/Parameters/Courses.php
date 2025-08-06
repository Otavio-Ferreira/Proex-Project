<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'status'];
}
