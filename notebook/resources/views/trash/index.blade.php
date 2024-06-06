@php
    use Illuminate\Support\Str;
@endphp

<x-layout heading="NOTES"> 

    <div class="space-y-4">
        
        @foreach($notes as $note) 
            <a href="/trash/{{ $note["id"] }}/edit" class = "block px-4 py-4 border border-gray-200 rounded-lg">
                
                <div class="flex font-bold text-blue-500 text-sm items-center justify-between"> 
                    <p> {{ $note->title }}</p>
                    <p>{{ $note->user->first_name .  $note->user->last_name}}</p>
                </div>

                <div>
                    <br/>
                    {{ Str::limit($note->content, 100, '...') }} 
                </div>
                
            </a>
        @endforeach

        {{-- <div>{{ $notes->links() }}</div> --}}

    </div>

</x-layout>