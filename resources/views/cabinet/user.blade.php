@extends('layouts.app')

@section('content')
    @component('cabinet.index')
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn">
                    вийти
                </button>
            </form>
        </div>
    @endcomponent
@endsection
