<div x-data="{ open: false }">
    <button @click="open = true"
        class="ml-4 px-6 py-2 rounded-lg bg-[#fff3] transition-all hover:bg-[#ffffff46] hover:text-white">Каталог</button>
    <div x-show="open" x-bind:class="open ? 'overlay' : ''">
        <div class="main"></div>
    </div>
    <div x-show="open" @click.away="open = false" class="top-full z-50  absolute">
        <div class="bg-white">
            qwxeqwqwe
        </div>
    </div>

</div>
