@extends('layouts.app')


@section('content')
    <div class="my-container">
        @livewire('brand.show',compact('brand'))
    </div>
@endsection
