@extends('layouts.admin.app')

@section('content')
    @livewire('admin.seo.dynamic-form',compact('model'))
@endsection
