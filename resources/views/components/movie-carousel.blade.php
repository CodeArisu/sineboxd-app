<!-- Title Section -->
<h2 class="text-3xl font-bold bg-gradient-to-r from-[#F3D72E] to-[#B85D48] bg-clip-text text-transparent mb-4"> 
  {{ $titleSection }}
</h2>

<div x-data="{
  currentSlideIndex: 0,
  slides: @json($slides),
  previous() {
    this.currentSlideIndex = (this.currentSlideIndex - 1 + this.slides.length) % this.slides.length;
  },
  next() {
    this.currentSlideIndex = (this.currentSlideIndex + 1) % this.slides.length;
  }
}" class="relative w-full overflow-hidden">

  <!-- Slides Container -->
  <div class="relative flex transition-transform duration-500"
    :style="`transform: translateX(-${currentSlideIndex * 20}%)`">
    <template x-for="(slide, index) in slides" :key="index">
      <div class="w-1/5 flex-shrink-0 px-2">
        <div class="flex flex-col items-center">
          <!-- Movie Poster -->
          <div class="w-40 h-[16rem] bg-gray-300 rounded-2xl overflow-hidden">
            <img :src="slide.poster" alt="Movie Poster" class="w-full h-full object-cover">
          </div>
          <!-- Movie Title -->
          <p class="mt-2 text-white text-center text-lg" x-text="slide.title"></p>
        </div>
      </div>
    </template>
  </div>

  <!-- Navigation Buttons -->
  <button class="absolute left-5 top-1/2 -translate-y-1/2" @click="previous">
    <img src="{{ asset('assets/left-arrow.png') }}" alt="Previous" class="w-6 h-6">
  </button>
  <button class="absolute right-5 top-1/2 -translate-y-1/2" @click="next">
    <img src="{{ asset('assets/right-arrow.png') }}" alt="Next" class="w-6 h-6">
  </button>
</div>
