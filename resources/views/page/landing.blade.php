@section('title', 'Landing Page')

@section('content')

@include('layouts.navbar') <!-- Include the navbar -->
<!-- <x-movie-card title="Inception" poster="https://image.tmdb.org/t/p/w500/your-image.jpg" />
<x-movie-card title="Interstellar" poster="https://image.tmdb.org/t/p/w500/your-image.jpg" /> -->

<button class="btn">Button</button>

<button type="button" class="collapse-toggle btn btn-primary" id="basic-collapse" aria-expanded="false" aria-controls="basic-collapse-heading" data-collapse="#basic-collapse-heading">
  Collapse
  <span class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4"></span>
</button>
<div id="basic-collapse-heading" class="collapse hidden w-full overflow-hidden transition-[height] duration-300" aria-labelledby="basic-collapse">
  <div class="border-base-content/25 mt-3 rounded-md border p-3">
    <p class="text-base-content/80">
      The collapsible body remains concealed by default until the collapse plugin dynamically adds specific classes. These classes are instrumental in styling each element, dictating the overall appearance, and managing visibility through CSS transitions.
    </p>
  </div>
</div>


@endsection
