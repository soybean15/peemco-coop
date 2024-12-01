<div>


    @if($isAdmin)
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">


            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>

                            <livewire:components.logout/>
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                @endif

                <x-menu-item title="Dashboard" icon="o-computer-desktop" link="{{route('admin.dashboard')}}" />
                <x-menu-sub title="Users" icon="o-user-group">
                    <x-menu-item title="List" link="{{route('admin.users')}}" exact/>
                    {{-- 'admin.user-archives' --}}
                    <x-menu-item title="Archives"  link="{{ route('admin.user-archives') }}" />
                </x-menu-sub>

                <x-menu-item title="Loan Type" icon="o-computer-desktop" link="{{route('admin.loan-type')}}" />

                <x-menu-sub title="Loans" icon="o-credit-card">

                    <x-menu-item title="Pending"  badge="{{ $pendingCount }}"   badge-classes="!badge-error" icon="o-clock" link="{{route('admin.pending')}}" />
                    <x-menu-item title="Active" icon="o-credit-card" link="{{route('admin.active')}}" />
                  {{--  <x-menu-item title="Completed" icon="s-check-circle" link="{{route('admin.completed')}}" />--}}
                    {{-- <x-menu-item title="Apply Loan" icon="o-calculator" link="{{route('admin.loan-calculator')}}"/> --}}
                    <x-menu-item title="Apply Loan" icon="o-calculator" link="{{route('admin.loan-application')}}"/>

                </x-menu-sub>
                <x-menu-sub title="Imports" icon="o-arrow-down-on-square">

                    <x-menu-item title="User"    link="{{route('admin.user-import')}}" />
                    <x-menu-item title="CBU"    link="{{route('admin.cbu-import')}}" />
                    {{-- <x-menu-item title="Active" icon="o-credit-card" link="{{route('admin.active')}}" /> --}}
                    {{--  <x-menu-item title="Completed" icon="s-check-circle" link="{{route('admin.completed')}}" />--}}
                    {{-- <x-menu-item title="Apply Loan" icon="o-calculator" link="{{route('admin.loan-calculator')}}"/> --}}
                </x-menu-sub>
                <x-menu-item title="Settings" icon="o-cog-6-tooth" link="{{route('admin.settings')}}" />

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    @else
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">


            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>

                            <livewire:components.logout/>
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                @endif

                <x-menu-item title="Dashboard" icon="o-computer-desktop" link="{{route('user.dashboard')}}" />
                <x-menu-item title="Profile" icon="o-user" link="{{route('user.profile')}}" />

                <x-menu-sub title="Loans" icon="o-credit-card">
                    <x-menu-item title="List" icon="s-numbered-list" link="{{route('user.loans')}}" exact/>
                    <x-menu-item title="Loan Calculator" icon="o-calculator" link="{{route('user.loan-calculator')}}"/>
                </x-menu-sub>
                <x-menu-item title="Capital Build Up" icon="o-arrow-trending-up" link="{{route('user.capital-build-up')}}" />


            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    @endif
</div>
