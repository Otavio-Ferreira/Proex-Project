<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["title", "date", "status"];
}
