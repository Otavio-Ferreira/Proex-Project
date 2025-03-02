<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitys extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["response_forms_id", "activity", "address"];
}
