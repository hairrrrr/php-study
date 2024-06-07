<x-layout> 
    <x-slot:heading>
        Create Note 
    </x-slot:heading>

<form method='POST' action="/notes" >
    @csrf
    
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Create a note</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">We need a handful details from you.</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <x-form-label for="title">Title</x-form-label>
                    <div class="mt-2">

                        <x-form-input type="text" name="title" id="title" required/>
                        <x-form-error name='title'/>

                    </div>
            </div>

            <div class="sm:col-span-4">
                <x-form-label for="content">Content</x-form-label>
                    
                    <div class="mt-2">
                      
                        <x-form-input type="text" name="content" id="content" required/>
                        <x-form-error name='content'/>
                    
                    </div>
            </div>

            {{-- <div class="sm:col-span-4">
                <x-form-label for="tag">Tag</x-form-label>
                    
                    <div class="mt-2">
                      
                        <x-form-input type="text" name="tag" id="tag" required/>
                        <x-form-error name='tag'/>
                    
                    </div>
            </div> --}}
        </div>

    
    </div>
    </div>
  
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <x-form-cancel href="/notes" class="bg-gray-600 hover:bg-gray-500 focus-visible:outline-indigo-500">
            Cancel
        </x-form-cancel>
        
        <x-form-button type="submit" class="bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600" >
            Save
        </x-form-button>
    </div>
  </form>
  

</x-layout>


