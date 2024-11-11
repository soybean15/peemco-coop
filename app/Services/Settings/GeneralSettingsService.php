<?php

namespace App\Services\Settings;

use App\Models\GeneralSetting;

class GeneralSettingsService{


    protected $settings;
    public function __construct(){
        $this->settings = GeneralSetting::firstOrCreate(
            [], // Condition to find the record
            [ // Default values for creating a new record
                'company_name' => 'Company Name',
                'address' => 'Company Address'
            ]
        );
    }

    public function getSettings(){
        return $this->settings;
    }




}
