@extends('layouts.app')


@section('content')
    <div class="my-container">
        @livewire('category.show',['category' => $category])
    </div>
@endsection
