<dialog id="modal" class="modal modal-vertical" @if ($open) open @endif>
    <div class="w-screen h-screen relative  bg-base-content opacity-40">
    </div>

    <div class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
        <form wire:submit.prevent="submit">
            <div class="text-xl font-bold mb-2">
                додати відгук
            </div>
            <div>
                <div class="rating">
                    @for ($i = 0; $i < 5; $i++)
                        <input type="radio" name="rating-2" wire:model='skuReview.rating'
                            class="mask mask-star-2 bg-orange-400" @if ($i === 0)  @endif
                            value='{{ $i + 1 }}' />
                    @endfor
                </div>
            </div>
            <div>
                @include('ui.form.textarea', [
                    'model' => 'skuReview.comment',
                    'label' => 'comment',
                ])
            </div>
            <div class="mt-2">
                <button type="submit" class="btn">
                    додати відгук
                </button>
            </div>
        </form>
    </div>
</dialog>
