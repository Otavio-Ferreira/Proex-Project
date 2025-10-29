<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ExternalPartners extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["response_forms_id", "name_partner", "institution_type", "partnership_type", "its_international"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["response_forms_id", "name_partner", "institution_type", "partnership_type", "its_international"])
            ->useLogName('external_partners_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
