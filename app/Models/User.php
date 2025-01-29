<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\LoanItemStatusEnum;
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

                $media = $this->getMedia('profile_photo');


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

    public function loanTypes(){
        return $this->hasMany(LoanTypeUser::class);
    }

    public function scopeAdminRoles(Builder $builder ){


        $builder->whereHas('roles', function ($query) {
            $query->whereIn('name', [RolesEnum::BOOK_KEEPER->value,RolesEnum::SUPER_ADMIN->value]);
        }) ;
    }


    public function scopeNoAdminRoles(Builder $builder)
    {
        $builder->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', [RolesEnum::BOOK_KEEPER->value, RolesEnum::SUPER_ADMIN->value]);
        });
    }

    public function jobProcess(){
        return $this->hasMany(JobProcess::class);
    }


    public function onGoingImports(){

        return $this->jobProcess()->whereNull('completed_at')->get();
    }


    public function canProcessLoan()
    {
        // If user has no loans, can process
        if ($this->loans()->doesntExist()) {
            return true;
        }
        // Check if user has any pending loans (assuming 'pending' status exists)
        if ($this->loans()->where('status', 'pending')->exists()) {
            return false;
        }

        // Get all active approved loans
        $activeLoans = $this->loans()
            ->where('status', 'approved')
            ->with('items') // Eager load loan items
            ->get();

        // If no active loans, can process
        if ($activeLoans->isEmpty()) {
            return true;
        }

        // Check all active loans' 3-month items
        foreach ($activeLoans as $loan) {
            $threeMonthItems = $loan->items()
                ->where('loan_period', 3)
                ->get();

            // If any 3-month item is not paid, cannot process
            if ($threeMonthItems->isEmpty() || !$threeMonthItems->every(function ($item) {
                return $item->status === LoanItemStatusEnum::PAID->value;
            })) {
                return false;
            }
        }

        return true;
    }
}
