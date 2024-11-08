<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles,SoftDeletes;
    use InteractsWithMedia;

    protected $guarded =[];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mid',
        'name',
        'middlename',
        'lastname',
        'username',
        'email',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function registerMediaConversions(?Media $media = null): void
{
    $this
        ->addMediaConversion('preview')
        ->fit(Fit::Contain, 300, 300)
        ->nonQueued();
}
    public function scopeSearch(Builder $builder,$search){


        return $builder->where('name','like',"%$search%")
        ->orWhere('email',$search);
    }

    public function avatar():Attribute{
        return Attribute::make(
            get: function (){

                $media = $this->getMedia('profile');


                if($media->last()){
                    return $media->last()->getUrl();
                }

                return null;


            }
        );
    }

    public function loans(){
        return $this->hasMany(Loan::class,'user_id');
    }

    public function capitalBuildUp(){
        return $this->hasMany(CapitalBuildUp::class,'user_id');
    }

    public function hasPermission($permission)
    {

        return $this->roles->contains(function ($role) use ($permission) {
            // dd($role->permissions->contains('name', $permission),$permission,$role,$role->permissions);
            return $role->permissions->contains('name', $permission);
        });
    }

    public function profile()
    {
            return $this->hasOne(UserProfile::class);
    }

    public function scopeAdminRoles(Builder $builder ){

        
        $builder->whereHas('roles', function ($query) {
            $query->whereIn('name', [RolesEnum::BOOK_KEEPER->value, RolesEnum::SUPER_ADMIN->value]);
        });
    }

}
