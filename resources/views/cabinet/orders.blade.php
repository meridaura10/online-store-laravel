@extends('layouts.app')

@section('content')
    @component('cabinet.index')
       @livewire('cabinet.order.index')
    @endcomponent
@endsection
