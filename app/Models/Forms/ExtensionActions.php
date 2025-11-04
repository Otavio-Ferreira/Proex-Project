<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class ExtensionActions extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ["response_forms_id", "title_action", "its_for_public_schools", "international_description"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["response_forms_id", "title_action", "its_for_public_schools", "international_description"])
            ->useLogName('extension_actions_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
