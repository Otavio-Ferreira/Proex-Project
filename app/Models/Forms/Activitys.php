<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activitys extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ["response_forms_id", "activity", "address", "latitude", "longitude", "place_id"];

    public function response() : BelongsTo{
        return $this->belongsTo(FormsResponse::class, 'id', 'response_forms_id');
    }
}
