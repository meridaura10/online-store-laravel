<header class="h-16 header-bg text-white fixed top-0 z-20  w-full">
    <div class="my-container h-[100%] flex items-center justify-between">
        <div class="flex">
            <a href="{{ route('home') }}" class="text-xl font-bold">Shoper</a>
            @livewire('header.catalog')
        </div>
        @livewire('header.search')
        <div class="flex gap-2 items-center">

            @foreach (config('localization.supported-locales') as $lg)
                @if ($lg != app()->getLocale())
                    <a href="{{ localization()->localizeURL(null, $lg) }}">
                        <button class="header-menu__lang btn-circle btn-circle--gray"
                            type="button">{{ strtoupper($lg) }}</button>
                    </a>
                @endif
            @endforeach


            @if (auth()->check())
                <a href="{{ route('cabinet.orders') }}">
                    <svg class="fill-white w-[28px] h-[28px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M21 20H23V22H1V20H3V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V20ZM19 20V4H5V20H19ZM8 11H11V13H8V11ZM8 7H11V9H8V7ZM8 15H11V17H8V15ZM13 15H16V17H13V15ZM13 11H16V13H13V11ZM13 7H16V9H13V7Z">
                        </path>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <button class="hover:bg-gray-700 p-2 rounded-xl transition-all">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                </a>
            @endif



            @livewire('header.basket')
        </div>
    </div>
</header>
