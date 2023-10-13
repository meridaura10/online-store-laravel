@extends('layouts.admin.app')

@section('content')
@livewire('admin.product.form',[
    'product' => $product,
])
@endsection
