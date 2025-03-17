<div class="mx-auto p-6 rounded-lg text-white bg-[#222222]">
    <h2 class="text-xl font-bold mb-4">Write a Review</h2>

    <!-- Star Rating System -->
    <div x-data="{ rating: 0 }" class="flex justify-center gap-1 text-yellow-400 mb-4">
        @for ($i = 1; $i <= 5; $i++)
            <img src="{{ asset('assets/star-gray.png') }}"
            alt="Star"
            class="w-8 h-8 cursor-pointer transition-transform transform hover:scale-110"
            :src="rating >= {{ $i }} ? '{{ asset('assets/star.png') }}' : '{{ asset('assets/star-gray.png') }}'"
            @click="rating = {{ $i }}">
            @endfor
    </div>


    <!-- Review Editor -->
    <textarea rows="5" placeholder="Write your review here..."
        class="w-full p-3 rounded-lg bg-[#222222] text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>

    <!-- Submit Button -->
    <button class="mt-3 px-4 py-2 bg-yellow-400 text-white font-semibold rounded-lg hover:bg-yellow-500 transition">
        Submit Review
    </button>
</div>