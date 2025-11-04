<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Forms extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["title", "date", "status"];

    public function responses(): HasMany
    {
        return $this->HasMany(FormsResponse::class, 'forms_id', 'id');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["title", "date", "status"])
            ->useLogName('form_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
