<x-layout > 
    <x-slot:heading>
        Edit Note: {{ $note->title }}
    </x-slot:heading>


    <form method='POST' action="/trash/{{ $note->id }}">
        @csrf
        @method('PATCH')

        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Edit a note</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Free your mind~</p>
      
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">

                    <x-form-label for="title">Title</x-form-label>
                        
                    <div class="mt-2">

                            <x-form-input 
                                type="text" 
                                name="title" 
                                id="title"
                                value="{{ $note->title }}"
                                required/>
                            
                            <x-form-error name='title'/>
    
                        </div>
                </div>
    
                <div class="sm:col-span-4">

                    <x-form-label for="content">content</x-form-label>
   
                        <div class="mt-2">
                          
                            <x-form-input 
                                type="text" 
                                name="content" 
                                id="content"
                                value="{{ $note->content }}"
                                required/>
                            
                            <x-form-error name='content'/>
                        
                        </div>
                </div>


                <div class="sm:col-span-4">

                    <x-form-label for="tag">tag</x-form-label>
   
                        <div class="mt-2">
                          
                            <x-form-input 
                                type="text" 
                                name="tag" 
                                id="tag"/>
                            
                            <x-form-error name='tag'/>
                        
                        </div>
                </div>

            </div>
    
        
        </div>
        </div>
      
        <div class="mt-6 flex items-center justify-between gap-x-6">
            
            <div>
                <x-form-button form='delete-form' class='bg-red-600 hover:bg-red-500 focus-visible:outline-indigo-600'>
                    Delete
                </x-form-button>
            </div>

            <div class="flex item-center gap-x-6">

                <x-form-cancel href="/trash" class='bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600'>
                    Cancel
                </x-form-cancel>
                
                <div>
                    <x-form-button type="submit" class='bg-green-600 hover:bg-green-500 focus-visible:outline-indigo-600'>
                        Recover
                    </x-form-button>
                </div>


            </div>

        </div>
      </form>

      <form method="POST" action="/trash/{{ $note->id }}" id='delete-form' class="hidden">
        @method('DELETE')
        @csrf

      </form>

</x-layout>
