<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Parameters extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["function", "value", "status"];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["function", "value", "status"])
            ->useLogName('parameter_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
