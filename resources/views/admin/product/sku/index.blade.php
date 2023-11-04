@extends('layouts.admin.app')

@section('content')
    @livewire('admin.product.sku.index',compact('product'))
@endsection
