@extends('layouts.app')


@section('content')
    <div class="my-container">
        @livewire('category.show',compact('category'))
    </div>
@endsection
