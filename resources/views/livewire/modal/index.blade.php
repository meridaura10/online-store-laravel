<dialog id="modal" class="modal modal-vertical" @if ($open) open @endif>
    <div class="w-screen h-screen relative  bg-base-content opacity-40" wire:click="hidden" >
    </div>

    <div class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
        <div class="flex justify-between items-center pb-4 border-b mb-4">
            <h3 class="text-xl font-bold">{{ $this->title() }}</h3>
            <div>
                <button wire:click='hidden' class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M14.293 5.293a1 1 0 011.414 0l.001.001c.39.391.39 1.023 0 1.414L11.414 10l4.294 4.293a1 1 0 11-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414 1 1 0 011.414 0L10 8.586l4.293-4.293z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        {{ $this->content() }}
    </div>
</dialog>
