@props(['poster'])

<div class="flex flex-col items-center">
    <div class="w-60 h-[20rem] bg-gray-300 rounded-2xl overflow-hidden">
        @if ($poster)
            <img src="{{ $poster }}" alt="" class="w-full h-full object-cover">
        @endif
    </div>
    
</div>
