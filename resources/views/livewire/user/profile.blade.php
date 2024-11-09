<?php

use Livewire\Volt\Component;
use App\Models\User;



new class extends Component {
    public $user;

    public function mount()
    {
        $this->user = Auth()->id();
    }



}; ?>

<div>
<div class="p-3 m-1 border-2 rounded shadow-md ">
        <div class="flex flex-col justify-start md:flex-row">

            {{$user}}
           
        </div>
    </div>
    
</div>
