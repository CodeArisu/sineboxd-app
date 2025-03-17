<div class="text-white p-4 rounded-xl flex gap-4 items-start w-full">
    <!-- Profile Image -->
    <div class="w-12 h-12 bg-gray-400 rounded-full overflow-hidden">
        <img src="{{ $profileImage }}" alt="{{ $username }}" class="w-full h-full object-cover">
    </div>

    <!-- Review Content -->
    <div class="flex-1">
        <!-- User Info -->
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-lg">{{ $username }}</h3>
            <div class="flex gap-1 text-yellow-400">
                @for ($i = 0; $i < $rating; $i++)
                    <img src="{{ asset('assets/star.png') }}" alt="Star" class="w-5 h-5">
                @endfor
            </div>
        </div>

        <!-- Review Text -->
        <p class="text-gray-300 text-sm mt-1">{{ $review }}</p>

        <!-- Like & Comment Count -->
        <div class="flex items-center gap-4 mt-3">
            <div class="flex items-center gap-1">
                <img src="{{ asset('assets/heart.png') }}" alt="Heart" class="w-5 h-5">
                <span class="text-gray-300 text-sm">{{ $likes }}</span>
            </div>
            <div class="flex items-center gap-1">
                <img src="{{ asset('assets/comment.png') }}" alt="Comment" class="w-5 h-5">
                <span class="text-gray-300 text-sm">{{ $comments }}</span>
            </div>
        </div>
    </div>
</div>