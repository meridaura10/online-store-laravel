<a href="{{ route('basket.index') }}">
    <button class="hover:bg-gray-700 p-2 rounded-xl relative  transition-all">
        <span
            class="absolute rounded-full text-[12px] font-bold p-1 px-2 bg-green-600 top-[-4px] right-[-5px]">{{ $quantity }}</span>
        <svg class="h-8 w-8 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <circle cx="9" cy="19" r="2" />
            <circle cx="17" cy="19" r="2" />
            <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
        </svg>
    </button>
   </a>