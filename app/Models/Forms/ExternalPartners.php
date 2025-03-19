<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalPartners extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["response_forms_id", "name_partner", "institution_type", "partnership_type"];
}
