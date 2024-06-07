<x-layout heading="NOTE DETAIL"> 

    <h2 class="font-bold"> {{ $note->title }} </h2>

    <p>
        {{ $note->content }}
    </p>

    @can('edit', $note)
    <p class="mt-6">
        <x-button href='/notes/{{ $note->id }}/edit' 
                  class='bg-green-600 hover:bg-green-500 focus-visible:outline-indigo-600'>
             Edit Note  
        </x-button>
    </p>
    @endcan

</x-layout>
