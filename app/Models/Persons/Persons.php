<?php

namespace App\Models\Persons;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["user_id", "coordinator_name", "coordinator_profile", "coordinator_siape", "coordinator_course"];
    
}
