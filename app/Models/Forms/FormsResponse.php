<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
