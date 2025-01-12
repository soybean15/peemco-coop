<?php

use Livewire\Volt\Component;
use App\Enums\RolesEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Services\Permissions\RolePermissionService;
use Mary\Traits\Toast;
use Illuminate\View\View;

new class extends Component {
    //
    use Toast;
    public $selectedTab = 'general';

    public $roles=[];

    

    public function rendering(View $view): void
    {
        $view->title('Admin - Settings');


    }


    public function mount(){

       $this->roles = (new RolePermissionService())->generateRolePermissions();
    }



    public function submit(){

         (new RolePermissionService())->savePermissions($this->roles);
         $this->success('Permissions Updated');
    }
}; ?>

<div>
    <x-header title="Settings" separator />
    <x-tabs wire:model="selectedTab">
        <x-tab name="general">
            <x-slot:label>
                General
                {{--
                <x-badge value="3" class="badge-primary" /> --}}
            </x-slot:label>

            <livewire:admin.settings.general-settings/>

        </x-tab>

        @can('process user management')
        <x-tab name="users">
            <x-slot:label>
                User Management
                {{--
                <x-badge value="3" class="badge-primary" /> --}}
            </x-slot:label>

         <livewire:admin.settings.user-management/>
        </x-tab>

        @endcan
        @can('process permissions')
        <x-tab name="roles" label="Roles And Permission">
            <div>Roles</div>

            @forelse ($roles as $key =>$value )

            <div>
                {{$key}}
            </div>

            <div class="px-10">
                @foreach ($value as $permission )

                @if( $permission['is_disabled'])

                <div class="my-2">
                    <x-checkbox label="{{ $permission['name'] }}"
                        wire:model="roles.{{ $key }}.{{ $loop->index }}.is_selected" disabled />
                    @else
                    <div class="my-2">
                        <x-checkbox label="{{ $permission['name'] }}"
                            wire:model="roles.{{ $key }}.{{ $loop->index }}.is_selected" />
                        @endif


                    </div>


                    @endforeach
                </div>



                @empty

                @endforelse

                <div class="flex my-5">
                    <x-button label="Save" class="btn-success btn-sm" wire:click='submit' />
                </div>
        </x-tab>

        @endcan

    </x-tabs>
</div>
