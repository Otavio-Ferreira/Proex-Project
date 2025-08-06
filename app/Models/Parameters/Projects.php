<?php

namespace App\Models\Parameters;

use App\Models\Forms\FormsResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    
    protected $fillable = ['title', 'type', 'modality', 'course', 'coordinator', 'start_date', 'end_date', 'status'];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class, 'coordinator', 'id');
    }

    public function course_name() :BelongsTo{
        return $this->belongsTo(Courses::class, 'course', 'id');
    }

    public function responses():HasMany{
        return $this->HasMany(FormsResponse::class, 'project_id', 'id');
    }
}
