@extends('layouts.app')
@section('content')
    <div class="flex ">
        <aside class="border-r fixed bg-white  z-[10000]  px-2 border-gray-200 w-full max-w-[300px] aside-h">
            <ul>
                <li>
                    <a href="{{ route('cabinet.user') }}" class="block border-b py-2 pl-2">
                        <div
                            class="hover:bg-[#00a04633] rounded-lg flex {{ request()->routeIs('cabinet.user') ? 'bg-[#00a04633]' : '' }} gap-3 py-2 px-2  items-center transition-colors">
                            <div class="">
                                <svg class="h-9 w-9 text-black " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-[-5px]">{{ auth()->user()->name ?? 'app' }}</h4>
                                <span class="text-slate-500 text-sm">{{ auth()->user()->email ?? 'app' }}</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cabinet.orders') }}" class="block py-2 pl-2">
                        <div
                            class="hover:bg-[#00a04633] rounded-lg {{ request()->routeIs('cabinet.orders') ? 'bg-[#00a04633]' : '' }} flex gap-3 py-2 px-2  items-center transition-colors">
                            <div>
                                <svg class="fill-black w-[28px] h-[28px]" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M21 20H23V22H1V20H3V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V20ZM19 20V4H5V20H19ZM8 11H11V13H8V11ZM8 7H11V9H8V7ZM8 15H11V17H8V15ZM13 15H16V17H13V15ZM13 11H16V13H13V11ZM13 7H16V9H13V7Z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4>Orders</h4>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </aside>
        <div class="ml-[300px] w-full">
            {{ $slot }}
        </div>
    </div>
@endsection
