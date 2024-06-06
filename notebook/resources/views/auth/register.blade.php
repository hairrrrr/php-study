<x-layout> 
    <x-slot:heading>
        Register
    </x-slot:heading>

<form method='POST' action="/register" >
    @csrf
    
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
  
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <div class="sm:col-span-4">
                <x-form-label for="first_name">First Name</x-form-label>
                    <div class="mt-2">

                        <x-form-input type="text" name="first_name" id="first_name" :value="old('first_name')" required/>
                        <x-form-error name='first_name'/>

                    </div>
            </div>

            <div class="sm:col-span-4">
                <x-form-label for="last_name">last name</x-form-label>
                    
                    <div class="mt-2">
                      
                        <x-form-input type="text" name="last_name" id="last_name" :value="old('last_name')" required/>
                        <x-form-error name='last_name'/>
                    
                    </div>
            </div>

            <div class="sm:col-span-4">
                <x-form-label for="email">Email</x-form-label>
                    
                    <div class="mt-2">
                        <x-form-input type="email" name="email" id="email" :value="old('email')" required/>
                        <x-form-error name='email'/>
                    </div>
            </div>


            <div class="sm:col-span-4">
                <x-form-label for="password">password</x-form-label>
                    
                    <div class="mt-2">
                      
                        <x-form-input type="password" name="password" id="password" required/>
                        <x-form-error name='password'/>
                    
                    </div>
            </div>

            <div class="sm:col-span-4">
                <x-form-label for="password_confirm">confirm password</x-form-label>
                    
                    <div class="mt-2">
                      
                        <x-form-input type="password" name="password_confirmation" id="password_confirmation" required/>
                        <x-form-error name='password_confirmation'/>
                    
                    </div>
            </div>
        </div>

    </div>
    </div>
  
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <x-form-cancel href="/login" class="bg-gray-600 hover:bg-gray-500 focus-visible:outline-indigo-500">
            Cancel
        </x-form-cancel>
        
        <x-form-button type="submit" class="bg-indigo-600 hover:bg-indigo-500 focus-visible:outline-indigo-600" >
            Save
        </x-form-button>
    </div>
  </form>
  

</x-layout>


