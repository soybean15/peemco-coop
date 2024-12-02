<div class="flex flex-col h-full">
    <div class="relative flex flex-col flex-grow overflow-hidden transition-all bg-white border border-gray-200 rounded-lg hover:shadow-lg">
        <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-green-500/10 to-green-500/5"></div>
        <div class="flex-grow p-6">
            <h2 class="flex items-center justify-between gap-2 mb-2 text-xl font-semibold">
                <div>{{$loanType->loan_type}}</div>
                <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-red-200 rounded-full">{{ $loanType->minimum_amount }}</span>

            </h2>
            <div class="space-y-4">
                <div>
                    <span class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">Release Dates</span>
                    <ul class="text-sm text-gray-600 list-disc list-inside">
                        @foreach ($loanType->releaseDates as $date)
                            <li>{{ $date->toString }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="p-6 mt-auto border-t border-gray-200 bg-gray-50">

            <x-button label="Apply" class="w-full text-base-100 btn btn-success" :disabled="$disabled" link="{{ route('admin.loan-cash-advance-list',['cashAdvance'=>$loanType]) }}"/>
        </div>
    </div>
</div>
