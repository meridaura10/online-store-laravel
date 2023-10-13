<div x-data="{ accordionShow: false }" class="collapse mt-3 collapse-arrow bg-base-200">
    <div @click="accordionShow = !accordionShow"
        class="w-full cursor-pointer flex px-4 items-center justify-between">
        <div>
            <p class="py-3 font-semibold">{{ $title }}</p>
        </div>
        <div class="w-6 h-6">
            <svg class="w-full h-full fill-gray-800" x-show="!accordionShow"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 8L18 14H6L12 8Z"></path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" x-show="accordionShow"
                class="fill-gray-800 w-full h-full" viewBox="0 0 24 24">
                <path d="M12 16L6 10H18L12 16Z"></path>
            </svg>
        </div>
    </div>
    <div x-show="accordionShow" x-transition class="p-4">
        {{ $slot }}
    </div>
</div>