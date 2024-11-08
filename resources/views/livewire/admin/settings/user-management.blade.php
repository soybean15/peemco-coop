<?php

use Livewire\Volt\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Services\Users\UserManagementService;
use Mary\Traits\Toast;
new class extends Component {


    use Toast;

    public $role_ids;
    public $selectedUsers = [];
    public function with(){

        // dd(User::adminRoles()->get());
        return [
            'users'=>User::adminRoles()->get(),
            'headers'=>[
                ['key' => 'id', 'label' => '#'],
                ['key' => 'user_name', 'label' => 'Name'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'roles', 'label' => 'Roles'],
                ['key' => 'action', 'label' => 'Action'],

            ]
        ];
    }

    public function removeSelected(){
        try {
            $service = app(UserManagementService::class);
            $service->removeRoles($this->selectedUsers);
            $this->success('Removed Selected User');


        } catch (\Exception $e) {
           $this->error($e->getMessage());
        }


    }
}; ?>

<div>

    @php

    try{
        $service = app(UserManagementService::class);

    }catch(\Exception $e){
        dd($e);
    }
    @endphp


    @if(count($selectedUsers)>0)
    <div class="flex items-center" x-data x-cloak x-transition>
        <div class="mx-4">{{ count($selectedUsers) }} Selected</div>
        <x-dropdown label="Actions" no-x-anchor>
            <x-menu-item title="Remove User" wire:click='removeSelected'/>

        </x-dropdown>
    </div>
    @endif
    <x-table :headers="$headers" :rows="$users" selectable wire:model.live='selectedUsers' >

        @scope('cell_roles',$user)

        @foreach ($user->roles as $role )
        @if($role->name =='super admin')
        <x-badge value="{{ $role->name }}" class="badge-secondary " />
        @else
        <x-badge value="{{ $role->name }}" class="bg-purple-500/10 " />

        @endif


        @endforeach

        @endscope
        @scope('cell_action',$user)




        </div>



        @endscope
    </x-table>


</div>
