<div class="card shadow-lg bg-base-100 my-2">
   <div class="card-body">
       @if(!$images->isEmpty())
           <ul wire:sortable="reorder" class="w-full flex flex-wrap">
               @foreach ($images as $key => $image)
                   <li wire:sortable.item='{{ $image->id }}'  key='{{ $image->id }}' class="p-2">
                       <div class="w-64 h-36 truncate card relative">
                           <img class="object-cover" src="{{ $image->url }}">

                           @if($key == 0)
                               <div class="absolute left-0 top-0">
                                   <div class="tooltip tooltip-right tooltip-success relative" data-tip="main image">
                                       <button class="btn btn-xs btn-success">
                                           <i class="ri-star-line"></i>
                                       </button>
                                   </div>
                               </div>
                           @endif
                           <div class="absolute left-0 bottom-0" wire:sortable.handle>
                               <div class="tooltip tooltip-right tooltip-warning relative" data-tip="drag and drop">
                                   <button class="btn btn-xs btn-warning">
                                       <i class="ri-drag-drop-line"></i>
                                   </button>
                               </div>
                           </div>
                           <div class="absolute right-0 bottom-0">
                               <div class="tooltip tooltip-left tooltip-error relative" data-tip="delete">
                                   <button class="btn btn-xs btn-error" wire:click.prevent='toDelete({{ $image->id }})'>
                                       <i class="ri-delete-bin-line"></i>
                                   </button>
                               </div>
                           </div>
                       </div>
                   </li>
               @endforeach
           </ul>
       @else
           <div class="flex justify-center items-center h-36 w-full">
               {{ trans('base.empty') }}
           </div>
       @endif
       <hr>
       <div class="card-actions justify-between">
           @include('ui.form.file', [
               'model' => 'storeImages',
               'style' => ' w-full max-w-xs'
           ])

           <button class="btn btn-primary" wire:click.prevent="saveImages">{{ trans('base.save') }}</button>
       </div>
   </div>
</div>
