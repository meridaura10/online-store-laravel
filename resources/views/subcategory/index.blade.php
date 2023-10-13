@extends('layouts.app')
@section('content')
    <div class="my-container pt-5">
        <div class="flex gap-3 justify-between mb-4 items-center">
            @foreach ($parenCategory->brands as $brand)
                <a href="/" class="opacity-60 hover:opacity-100 transition-all">
                    <img class="object-contain w-[100px]" src="{{ $brand->image->url }}" alt="">
                </a>
            @endforeach
        </div>
        <div class="flex flex-col lg:flex-row ">
            <div class="pt-24  w-[100%] ">
                <ul class="flex justify-between gap-3">
                    @foreach ($categories as $category)
                        <li
                            class="flex items-center text-center border">
                            <a class="p-4 hover:text-[#f84147] text-[#3e77aa] hover:underline" href="{{ route('categories.show', $category) }}">
                                <img class="w-[340px] h-[250px] object-contain mb-4" src="{{ $category->image->url }}" alt="">
                                <p class=" px-14 text-lg cursor-pointer   mt-4  transition-all">{{ $category->name }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
