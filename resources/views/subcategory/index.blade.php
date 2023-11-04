@extends('layouts.app')
@section('content')
    <div class="my-container pt-5">
        <div class="flex gap-3 justify-between mb-4 items-center">
            @foreach ($parenCategory->brands as $brand)
                <a href="{{ route('brands.show',$brand) }}" class="opacity-60 hover:opacity-100 transition-all">
                    <img class="object-contain w-[100px]" src="{{ $brand->image->url }}" alt="">
                </a>
            @endforeach
        </div>
        {{-- {{ $type }} --}}
        <div class="mb-10">
            <div class="pt-8  w-[100%] ">
                <ul class="grid grid-cols-6 gap-4">
                    @foreach ($categories as $key => $category)
                        <li class=" mb-2">
                            <div class="flex items-center">
                                <a class="p-4 hover:text-[#f84147] border-r @if (count($category->subcategories)) text-left whitespace-nowrap @else text-center @endif  text-[#3e77aa] hover:underline"
                                    href="{{ route('categories.show', $category) }}">
                                    <img class="w-[340px] h-[200px] object-contain mb-4" src="{{ $category->image->url }}"
                                        alt="">
                                    <div class="text-ellipsis ">
                                        <p class="text-lg w-full cursor-pointer overflow-ellipsis  mt-4 transition-all">
                                            {{ $category->name }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <ul class="mx-4 grid gap-1">
                                @foreach ($category->subcategories as $category)
                                    <a href="{{ route('categories.show', $category) }}"
                                        class="hover:text-[#f84147] hover:underline transition-all text-[#3e77aa] ">
                                        <div class="text-ellipsis ">
                                            <p class="w-full text-sm cursor-pointer overflow-ellipsis  transition-all">
                                                {{ $category->name }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
