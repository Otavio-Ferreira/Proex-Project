<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forms extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["title", "date", "status"];

    public function responses():HasMany{
        return $this->HasMany(FormsResponse::class, 'forms_id', 'id');
    }
}
