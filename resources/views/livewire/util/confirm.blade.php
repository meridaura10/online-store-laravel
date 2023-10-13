
<dialog id="modal" class="modal" @if($open) open @endif>
    <div class="w-screen h-screen relative  bg-base-content opacity-40">
    </div>
    <form method="dialog" class="modal-box absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
        <h3 class="font-bold text-lg">{{ $title }}</h3>
        <p class="py-4">{{ $description }}</p>
        <div class="modal-action">
          <!-- if there is a button in form, it will close the modal -->
          <button class="btn" wire:click="confirmed">Підтвердити</button>
          <button class="btn">Close</button>
        </div>
      </form>
</dialog>
