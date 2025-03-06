<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
