@extends('layouts.admin.app')

@section('content')
@livewire('admin.brand.form',[
    'brand' => $brand,
])
@endsection
