<x-layout heading="NOTE DETAIL"> 

    <h2 class="font-bold"> {{ $note->title }} </h2>

    <p>
        {{ $note->content }}
    </p>

    @can('edit', $note)
    <p class="mt-6">
        <x-button href='/trash/{{ $note->id }}/edit'> Edit Note  </x-button>
    </p>
    @endcan

</x-layout>
