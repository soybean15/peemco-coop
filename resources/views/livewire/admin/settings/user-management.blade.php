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
    public $newUsers=[];
    public $users_multi_searchable_ids=[];

    public $admins;
    public $users;
    public $headers;

    public function mount()
    {
        // Initialize properties when the component mounts
        $this->admins = User::adminRoles()->get();
        $this->users = User::noAdminRoles()->take(5)->get();

        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'roles', 'label' => 'Role'],
        ];

        $this->search();
    }

    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::whereIn('id', $this->users_multi_searchable_ids)->get();

        $this->users = User::query()
           ->search($value)
           ->noAdminRoles()
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);     // <-- Adds selected option
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

    public function addSelected(){
        $service = app(UserManagementService::class);
        $service->addAdminRoles($this->users_multi_searchable_ids);
        $this->success('Added Selected User');
        $this->dispatch('refresh-page');
    }
}; ?>

<div x-on:refresh-page.window="$wire.$refresh()">

    <x-header title="User Management" subtitle="" size="text-xl" separator />


    @php

    try{
        $service = app(UserManagementService::class);

    }catch(\Exception $e){
        dd($e);
    }
    @endphp


    <div class="flex items-center justify-between">
        <div>
        @if(count($selectedUsers)>0)
            <div class="flex items-center" x-data x-cloak x-transition>
                <div class="mx-4">{{ count($selectedUsers) }} Selected</div>
                <x-dropdown label="Actions" no-x-anchor>
                    <x-menu-item title="Remove Selecter Users" wire:click='removeSelected'/>

                </x-dropdown>
            </div>
        @endif
        </div>

        <div class="flex items-end">

        <x-choices
        label="Add Book keeper"
         placeholder="Search ..."
        search-function="search"
        no-result-text="Ops! Nothing here ..."
        wire:model="users_multi_searchable_ids"
        :options="$users"
        searchable
        class="w-[300px]"/>
        <x-button class="mx-3 mb-1 btn btn-primary " label='Add Book keeper' wire:click='addSelected'/>
    </div>
    </div>
    <x-table :headers="$headers" :rows="$admins" selectable wire:model.live='selectedUsers' >

        @scope('cell_roles',$user)

        @foreach ($user->roles as $role )
        @if($role->name =='super admin')
        <x-badge value="{{ $role->name }}" class="badge-secondary " />
        @elseif($role->name =='book keeper')
        <x-badge value="{{ $role->name }}" class="badge-info " />

        {{-- <x-badge value="{{ $role->name }}" class="bg-purple-500/10 " /> --}}

        @endif


        @endforeach

        @endscope

    </x-table>


</div>
