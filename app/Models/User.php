<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Persons\Persons;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasRoles, HasApiTokens, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'int_id',
        'active_role'
    ];
    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function persons()
    {
        return $this->hasOne(Persons::class, 'user_id');
    }

    public function activeRoleHasPermission(string $permission): bool
    {
        if (!$this->active_role) {
            return false;
        }

        $role = Role::findByName($this->active_role);

        return $role ? $role->hasPermissionTo($permission) : false;
    }

    // protected static function booted()
    // {
    //     static::creating(function ($user) {
            
    //         if (empty($user->int_id)) {
    //             $user->int_id = (self::max('int_id') ?? 0) + 1;
    //         }
    //     });
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['email', 'name', 'status', 'active_role'])
            ->useLogName('user_params')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getActivitylogSubjectId()
    {
        return $this->id; // força a usar o ID como subject_id
    }
}