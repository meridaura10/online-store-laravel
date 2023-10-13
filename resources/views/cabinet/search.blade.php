@extends('layouts.app')

@section('content')
    @component('cabinet.index')
      @livewire('order.search')
    @endcomponent
@endsection
