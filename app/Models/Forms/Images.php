<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Images extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["response_forms_id", "image", "address", "date", "description", "latitude", "longitude", "place_id"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["response_forms_id", "image", "address", "date", "description", "latitude", "longitude", "place_id"])
            ->useLogName('image_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
