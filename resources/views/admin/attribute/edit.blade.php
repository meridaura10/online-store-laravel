@extends('layouts.admin.app')

@section('content')
    @livewire('admin.attribute.form', compact('attribute'))
@endsection
