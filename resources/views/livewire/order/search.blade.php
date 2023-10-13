<dialog id="modal" class="modal modal-vertical" @if ($openModal) open @endif>
    <div class="w-screen h-screen fixed top-0 left-0 flex items-center justify-center bg-base-content opacity-40">
    </div>

    <div
        class="max-w-xl w-full bg-white min-h-max absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-4 rounded-lg shadow-lg">
        <div>
            <div class="font-bold text-xl border-b pb-4 mb-2 flex justify-between gap-2">
                <h2>
                    @if ($phoneVerify === 'processed')
                        Підтвердіть номер через sms
                    @else
                        Ваш номер для пошуку замовлень
                    @endIf
                </h2>
                <button wire:click='hiddenModal' class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M14.293 5.293a1 1 0 011.414 0l.001.001c.39.391.39 1.023 0 1.414L11.414 10l4.294 4.293a1 1 0 11-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414 1 1 0 011.414 0L10 8.586l4.293-4.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form wire:submit.prevent="submit" class="mt-4">
                @if ($phoneVerify === 'processed')
                    <div class="flex items-center justify-between">
                        <input wire:model='code' class="border p-2" maxlength="4" type="text">
                        <div>
                            <span class="font-semibold"><span class="font-bold">ваш номер:</span>
                                {{ $phone }}</span>
                            <button type="button" class="btn btn-xs join-item" wire:click='editPhone'>

                                <i class="ri-pencil-line"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between mt-4 items-center">
                        <div class="font-semibold">
                            можливо буде через: 12
                        </div>
                        <button class="btn">
                            відправити ще раз
                        </button>
                    </div>
                @else
                    <div>
                        <div class="mb-8">
                            <label for="tel" class="block mb-2  font-medium text-gray-900 :text-white">Your
                                phone</label>
                            <input type="tel" wire:model='phone' id="tel"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500"
                                placeholder="+380995088087">
                        </div>
                        <button type="submit" class="btn">
                            підтвердити
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</dialog>
