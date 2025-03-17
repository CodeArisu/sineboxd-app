<nav class="bg-[#141817] bg-opacity-40 text-white p-3 rounded-full flex items-center justify-between max-w-6xl mx-auto shadow-lg">
    <!-- Left Section: Logo & Navigation -->
    <div class="flex items-center gap-6">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('assets/sineboxd-icon.png') }}" alt="Filmboxd Logo" class="h-10 w-10 mr-2">
            <img src="{{ asset('assets/sineboxd-logo.png') }}" alt="Filmboxd Logo" class="h-10">
        </div>
        <!-- Navigation Links -->
        <ul class="flex space-x-6 ">
            <li><a href="#" class="hover:text-yellow-400 font-semibold">Home</a></li>
            <li><a href="#" class="hover:text-yellow-400 font-semibold">Movies</a></li>
            <li><a href="#" class="hover:text-yellow-400 font-semibold">Cinema</a></li>
        </ul>
    </div>

    <!-- Right Section: Search Bar & Register Button -->
    <div class="flex items-center space-x-4">
        <!-- Search Bar -->
        <div class="relative">
    <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
        <img src="{{ asset('assets/search-icon.png') }}" alt="Search Icon" class="">
    </span>
    <input type="text" placeholder=" Search"
        class="bg-gray-300 text-black rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
</div>
        <!-- Register Button -->
        <button class="bg-yellow-400 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-yellow-400/50">
            Register
        </button>
    </div>
</nav>
