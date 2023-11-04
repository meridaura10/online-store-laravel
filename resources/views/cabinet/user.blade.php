@extends('layouts.app')

@section('content')
    @component('cabinet.index')
        <div class="p-6">
            <div class="text-lg mb-2">
                <div>
                    <span class="font-semibold">name</span>: {{ $user->name }}
                </div>
                <div>
                    <span class="font-semibold">email</span>: {{ $user->email }}
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn">
                    вийти
                </button>
            </form>
        </div>
    @endcomponent
@endsection
