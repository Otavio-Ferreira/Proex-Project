<?php

namespace App\Models\Forms;

use App\Models\Parameters\Projects;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class InternalPartners extends Model
{
    use HasFactory, HasUuids, LogsActivity;

    protected $fillable = ["response_forms_id", "title_partner"];

    public function title_action_partner() :BelongsTo{
        return $this->belongsTo(Projects::class, 'title_partner', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(["response_forms_id", "title_partner"])
            ->useLogName('internal_partners_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
