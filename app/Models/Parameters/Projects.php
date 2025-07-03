<?php

namespace App\Models\Parameters;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    
    protected $fillable = ['title', 'type', 'modality', 'course', 'coordinator', 'start_date', 'end_date', 'status'];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class, 'coordinator', 'id');
    }
}
