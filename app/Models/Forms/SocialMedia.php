<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SocialMedia extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["response_forms_id", "name", "link"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["response_forms_id", "name", "link"])
            ->useLogName('social_media_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
