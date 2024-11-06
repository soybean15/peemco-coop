<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'tin_no',
        'date_accepted',
        'acceptance_membership_bod_resolution_no',
        'type_of_membership',
        'number_of_share',
        'amount',
        'initial_paid_up',
        'address',
        'date_of_birth',
        'gender',
        'civil_status',
        'highest_educational_attainment',
        'occupational_income_source',
        'number_of_dependents',
        'religion_social_affiliation',
        'annual_income',
        'termination_membership_bod_resolution_no',
        'termination_membership_date'
    ];
}
