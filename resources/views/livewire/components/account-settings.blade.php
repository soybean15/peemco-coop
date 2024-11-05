<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $user;

    public function mount($user_id){

        $this->user = User::find($user_id);

    }
}; ?>

<div>
    {{$user->id}}
</div>
