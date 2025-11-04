<?php

namespace App\Models\Persons;

use App\Models\Parameters\Courses;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Persons extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["user_id", "coordinator_name", "coordinator_profile", "coordinator_siape", "coordinator_course"];
    
    public function course(): HasOne{
        return $this->hasOne(Courses::class, 'id', 'coordinator_course');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["user_id", "coordinator_name", "coordinator_profile", "coordinator_siape", "coordinator_course"])
            ->useLogName('person_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
