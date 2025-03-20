@section('title', 'Landing Page')

@section('content')


    <div class="relative left-1/2 -translate-x-1/2 w-[98.7vw] h-[100vh] flex items-center justify-center -mt-20 -z-10"
        x-data="{
            autoplayIntervalTime: 10000,
            slides: [{
                    imgSrc: 'assets/in the mood for love.png',
                    movieTitle: 'In the Mood for Love',
                    director: 'Wong Kar-wai',
                    description: 'A tale of love and longing set in 1960s Hong Kong.',
                },
                {
                    imgSrc: 'assets/happy together.jpg',
                    movieTitle: 'Happy Together',
                    director: 'Wong Kar-wai',
                    description: 'A story of love and heartbreak set in Buenos Aires.',
                },
                {
                    imgSrc: 'assets/fallen angels.jpg',
                    movieTitle: 'Fallen Angels',
                    director: 'Wong Kar-wai',
                    description: 'A story of love and heartbreak set in Hong Kong.',
                },
            ],
            currentSlideIndex: 1,
            isPaused: false,
            autoplayInterval: null,
            previous() {
                this.currentSlideIndex = this.currentSlideIndex > 1 ?
                    this.currentSlideIndex - 1 :
                    this.slides.length;
            },
            next() {
                this.currentSlideIndex = this.currentSlideIndex < this.slides.length ?
                    this.currentSlideIndex + 1 :
                    1;
            },
            autoplay() {
                this.autoplayInterval = setInterval(() => {
                    if (!this.isPaused) {
                        this.next();
                    }
                }, this.autoplayIntervalTime);
            },
            setAutoplayInterval(newIntervalTime) {
                clearInterval(this.autoplayInterval);
                this.autoplayIntervalTime = newIntervalTime;
                this.autoplay();
            },
        }" x-init="autoplay">

        <!-- Slides -->
        <div class="relative w-full h-full">
            <template x-for="(slide, index) in slides" x-bind:key="index">
                <div x-cloak x-show="currentSlideIndex == index + 1" class="absolute inset-0"
                    x-transition.opacity.duration.1000ms>

                    <!-- Image -->
                    <img class="w-full h-full object-cover" x-bind:src="slide.imgSrc" />

                    <!-- Gradients with pointer-events-none to prevent blocking clicks -->
                    <div
                        class="absolute bottom-0 left-0 w-full h-[140vh] bg-gradient-to-t from-[#222222] via-[#222222]/20 to-transparent pointer-events-none">
                    </div>
                    <div
                        class="absolute left-0 top-0 h-full w-[25vw] bg-gradient-to-r from-[#222222] via-[#222222]/20 to-transparent pointer-events-none">
                    </div>
                    <div
                        class="absolute right-0 top-0 h-full w-[25vw] bg-gradient-to-l from-[#222222] via-[#222222]/20 to-transparent pointer-events-none">
                    </div>

                    <!-- Movie Details -->
                    <div class="absolute bottom-20 left-40 text-white text-left">
                        <h3 class="text-6xl font-semibold" x-text="slide.movieTitle"></h3>
                        <p class="text-md font-light mt-2">Directed by: <span x-text="slide.director"></span></p>
                        <p class="text-md mt-2 font-light" x-text="slide.description"></p>

                    </div>
                </div>
            </template>
        </div>

    </div>



    <!-- Popular this week -->
    <h2 class="mt-20 text-3xl font-bold bg-gradient-to-r from-[#F3D72E] to-[#B85D48] bg-clip-text text-transparent mb-4">
        Popular this Week
    </h2>

    <div x-data="{
        currentSlideIndex: 0,
        slides: [
            @foreach ($popular as $movies)
            { 
               id: {{ $movies->id }}, 
               poster: 'https://image.tmdb.org/t/p/w500/{{ $movies->poster }}', 
               title: '{{ addslashes($movies->title) }}' 
            }, 
            @endforeach
        ],
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
                        <a :href="'/movie/detail/' + slide.id">
                            <div class="w-40 h-[16rem] bg-gray-300 rounded-2xl overflow-hidden">
                                <img :src="slide.poster" alt="Movie Poster" class="w-full h-full object-cover">
                            </div>
                        </a>
                        <!-- Movie Title -->
                        <p class="mt-2 text-white text-center text-lg" x-text="slide.title"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <button class="absolute left-5 top-1/2 -translate-y-1/2" @click="previous">
            <img src="assets/left-arrow.png" alt="Previous" class="w-6 h-6">
        </button>
        <button class="absolute right-5 top-1/2 -translate-y-1/2" @click="next">
            <img src="assets/right-arrow.png" alt="Next" class="w-6 h-6">
        </button>
    </div>


    <!-- In Theaters -->
    <h2 class="mt-20 text-3xl font-bold bg-gradient-to-r from-[#F3D72E] to-[#B85D48] bg-clip-text text-transparent mb-4">
        In Theaters
    </h2>

    <div x-data="{
        currentSlideIndex: 0,
        slides: [
            @foreach ($latest as $movies)
              { 
               id: {{ $movies->id }}, 
               poster: 'https://image.tmdb.org/t/p/w500/{{ $movies->poster }}', 
               title: '{{ addslashes($movies->title) }}' 
            }, 
            @endforeach
        ],
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
                        <a :href="'/movie/detail/' + slide.id">
                            <div class="w-40 h-[16rem] bg-gray-300 rounded-2xl overflow-hidden">
                                <img :src="slide.poster" alt="Movie Poster" class="w-full h-full object-cover">
                            </div>
                        </a>
                        <!-- Movie Title -->
                        <p class="mt-2 text-white text-center text-lg" x-text="slide.title"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <button class="absolute left-5 top-1/2 -translate-y-1/2" @click="previous">
            <img src="assets/left-arrow.png" alt="Previous" class="w-6 h-6">
        </button>
        <button class="absolute right-5 top-1/2 -translate-y-1/2" @click="next">
            <img src="assets/right-arrow.png" alt="Next" class="w-6 h-6">
        </button>
    </div>

    <!-- Coming soon to theaters -->
    <h2 class="mt-20 text-3xl font-bold bg-gradient-to-r from-[#F3D72E] to-[#B85D48] bg-clip-text text-transparent mb-4">
        Coming soon to theaters
    </h2>

    <div x-data="{
        currentSlideIndex: 0,
        slides: [
            @foreach ($upcoming as $movies)
              { 
               id: {{ $movies->id }}, 
               poster: 'https://image.tmdb.org/t/p/w500/{{ $movies->poster }}', 
               title: '{{ addslashes($movies->title) }}' 
              }, @endforeach
        ],
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
                        <a :href="'/movie/detail/' + slide.id">
                            <div class="w-40 h-[16rem] bg-gray-300 rounded-2xl overflow-hidden">
                                <img :src="slide.poster" alt="Movie Poster" class="w-full h-full object-cover">
                            </div>
                        </a>
                        <!-- Movie Title -->
                        <p class="mt-2 text-white text-center text-lg" x-text="slide.title"></p>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <button class="absolute left-5 top-1/2 -translate-y-1/2" @click="previous">
            <img src="assets/left-arrow.png" alt="Previous" class="w-6 h-6">
        </button>
        <button class="absolute right-5 top-1/2 -translate-y-1/2" @click="next">
            <img src="assets/right-arrow.png" alt="Next" class="w-6 h-6">
        </button>
    </div>
@endsection
