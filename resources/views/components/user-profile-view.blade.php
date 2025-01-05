<div>
    <div class="p-3 m-1 border-2 border-gray-600 rounded shadow-md ">
        <div class="flex flex-col justify-start md:flex-row">



            <div class="flex justify-center my-5 md:p-20">

                <x-mary-avatar class="!w-52" :image="$user->profile_photo_url" />
                {{-- <x-mary-file wire:model="photo" accept="image/png" crop-after-change>
                    <img src="{{ $user->avatar ?? '/storage/defaults/user-default.png' }}" class="h-40 rounded-lg" />
                </x-mary-file> --}}
            </div>

    
            <div class="flex flex-col w-full px-5 md:p-5">

                {{-- {{html_entity_decode($user->name)}} --}}
                <x-mary-header title="{{html_entity_decode($user->name)}}" subtitle="{{$user->email}}" separator />


                <div class="grid grid-cols-1 gap-2 md:grid-cols-3 ">
                    <x-mary-stat class="border-2 border-gray-600 rounded shadow-md" title="Gym Credit" description="This month" value="{{$credit->amount}}" icon="s-credit-card"
                    tooltip-bottom="There" />



                    <x-mary-stat class="border-2 border-gray-600 rounded shadow-md" title="Active Membership" description="This month" value="{{$membership->status}}" icon="s-user-plus"
                        tooltip-bottom="There" />


                    <x-mary-stat class="border-2 border-gray-600 rounded shadow-md" title="Active Subscription" description="{{$subscription?->remaining}}" value="{{ $subscription->package->name ?? 'No Active Subscription'}}" icon="m-gift"
                        tooltip-bottom="There" />

                </div>

            </div>

        </div>

        <div class="flex justify-end">
            <x-mary-button label='Reload' icon='o-credit-card' link="{{route('user.request-load',['user'=>$this->user->id])}}" class="btn-primary btn-sm"/>
        </div>
        <div>{{$tabs}}</div>
    </div>
</div>
