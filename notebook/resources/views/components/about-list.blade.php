@props(['finish' => false])


<li class="flex justify-between gap-x-6 py-5 px-20 mx-20">
    <div class="flex min-w-0 gap-x-4">

        <div class="min-w-0 flex-auto">
        <p class="text-lg font-semibold  leading-6 text-gray-900">{{ $slot }}</p>
        </div>

    </div>
    <div class="hidden shrink-0 sm:flex sm:items-end">
        
        <div class="{{ $finish ? 'bg-emerald-500/20' : 'bg-red-500/20' }} flex-none rounded-full  p-1">
            <div class="{{ $finish ? 'bg-emerald-500' : 'bg-red-500' }} h-3 w-3 rounded-full "></div>
        </div>
        <p class="text-lg leading-5 text-gray-900">{{ $finish ? 'Completed' : 'On Process' }}</p>
    
    </div>
</li>


