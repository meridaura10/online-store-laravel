@extends('layouts.app')
@section('content')
<div class="flex flex-col lg:flex-row my-container">
    @include('home.categoryList')
    <main class="w-full pt-4 lg:border-l pl-0 lg:pl-8">
        {{-- <div x-data="{ slide: 1, slides: 3 }" class="relative">
            <div class="flex w-full">
              <div x-show="slide === 1" class="w-full">
                <img src="https://content2.rozetka.com.ua/banner_main/image_ua/original/355736523.jpg" alt="Slide 1" class="w-full">
              </div>
              <div x-show="slide === 2" class="w-full">
                <img src="https://content.rozetka.com.ua/banner_main/image_ua/original/355841922.jpg" alt="Slide 2" class="w-full">
              </div>
              <div x-show="slide === 3" class="w-full">
                <img src="https://content2.rozetka.com.ua/banner_main/image_ua/original/353732461.jpg" alt="Slide 3" class="w-full">
              </div>
            </div>
          
            <div class="absolute bottom-0 left-0 right-0 flex justify-center mt-4">
              <template x-for="index in slides">
                <button
                  x-bind:class="{ 'bg-indigo-500': slide === index, 'bg-gray-300': slide !== index }"
                  class="h-2 w-2 rounded-full mx-1 focus:outline-none"
                  x-on:click="slide = index"
                ></button>
              </template>
            </div>
          </div> --}}
        
        @include('home.productList')
    </main>
</div>
@endsection
