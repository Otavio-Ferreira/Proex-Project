<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Comments extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['form_response_id', 'comment'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['form_response_id', 'comment'])
            ->useLogName('comments_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
