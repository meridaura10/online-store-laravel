@extends('layouts.admin.app')

@section('content')
    @livewire('admin.user.index')
    @livewire('admin.datatable.modal.change-field-modal')
@endsection
