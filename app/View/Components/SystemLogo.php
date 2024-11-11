<?php

namespace App\View\Components;

use App\Services\Settings\GeneralSettingsService;
use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SystemLogo extends Component
{
    /**
     * Create a new component instance.
     */

    public $logo;
    public $settings;
    public function __construct(
        public bool $hasName = false,
        public string $class = '',
        public string $size='20',
    )
    {
        //
        // dd($withName);

        try{

            $service = app(GeneralSettingsService::class);

            $this->settings= $service->getSettings();
            $this->logo = $this->settings->logo;
        }catch(Exception $e){
            dd($e);
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.system-logo');
    }
}
