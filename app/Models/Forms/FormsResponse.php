<?php

namespace App\Models\Forms;

use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FormsResponse extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'forms_id',
        'user_id',
        'title_action',
        'type_action',
        'action_modality',
        'cordinator_name',
        'cordinator_profile',
        'cordinator_siape',
        'coordinator_course',
        'qtd_internal_audience',
        'qtd_external_audience',
        'advances_extensionist_action',
        'social_technology_development',
        'instrument_avaliation',
        'was_finished'
    ];

    public function activitys() : HasMany{
        return $this->hasMany(Activitys::class, 'response_forms_id', 'id');
    }

    public function internal_partners() : HasMany{
        return $this->hasMany(InternalPartners::class, 'response_forms_id', 'id');
    }

    public function external_partners() : HasMany{
        return $this->hasMany(ExternalPartners::class, 'response_forms_id', 'id');
    }

    public function extension_actions() : HasMany{
        return $this->hasMany(ExtensionActions::class, 'response_forms_id', 'id');
    }

    public function social_medias() : HasMany{
        return $this->hasMany(SocialMedia::class, 'response_forms_id', 'id');
    }

    public function images() : HasMany{
        return $this->hasMany(Images::class, 'response_forms_id', 'id');
    }

    public function user() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function action() : BelongsTo{
        return $this->belongsTo(Projects::class, 'title_action', 'id');
    }

    public function course() : BelongsTo{
        return $this->belongsTo(Courses::class, 'coordinator_course', 'id');
    }

    public function comment() : HasOne{
        return $this->hasOne(Comments::class, 'form_response_id', 'id');
    }

    // public function form():BelongsToMany{
    //     return $this->belongsToMany(Forms::class, 'id', 'forms_id');
    // }
}
