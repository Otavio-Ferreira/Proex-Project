<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['form_response_id', 'comment'];
}
