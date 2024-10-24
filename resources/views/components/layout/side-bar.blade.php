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
                    <x-menu-item title="List" link="{{route('admin.users')}}" />
                    <x-menu-item title="Archives"  link="####" />
                </x-menu-sub>
                <x-menu-item title="Loans" icon="o-calculator" link="{{route('admin.loans')}}" />
                <x-menu-item title="Loan Calculator" icon="o-credit-card" link="{{route('admin.loan-calculator')}}" />
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


                <x-menu-sub title="Loans" icon="o-credit-card">
                    <x-menu-item title="List" icon="s-numbered-list" link="{{route('user.loans')}}" />
                    <x-menu-item title="Loan Calculator" icon="o-calculator" link="{{route('user.loan-calculator')}}"/>
                </x-menu-sub>

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    @endif
</div>
