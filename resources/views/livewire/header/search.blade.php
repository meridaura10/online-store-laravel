<div class="w-[50%]">
    <div class="relative w-full ">
        <input wire:model='value' wire:focus='show'  type="text"
            class="bg-gray-700 relative z-10 w-full text-white px-4 py-2 {{ $showDropdown ? 'rounded-t-lg ring-2 ring-blue-500' : 'rounded-lg' }} focus:outline-none "
            placeholder="Пошук">
        <ul class="absolute ring-2 ring-blue-500 z-10 bg-gray-800 w-full  py-2 rounded-b-lg shadow-2xl
            {{ $showDropdown ? '' : 'hidden' }}
             ">
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-700">Результат 1</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-700">Результат 2</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-gray-700">Результат 3</a></li>
        </ul>
    </div>
    <div wire:click='hidden' class="{{$showDropdown ? 'overlay' : ''}}">
        <div class="main"></div>
    </div>
</div>
