@extends('layouts.app')

@section('content')
    <div id="motorcycle">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="page-header">{{ $motorcycle->title }}</h1>

                    <p class="description">{{ $motorcycle->description }}</p>

                    <p class="phone-number">
                        <strong>Call seller at: {{ $motorcycle->phone_number }}</strong>
                    </p>

                    <hr>

                    @if(!$motorcycle->media->isEmpty())
                        <div class="images text-center">
                            @foreach($motorcycle->media as $item)
                                @php $title = $motorcycle->title . ' | Image ' . $loop->iteration @endphp

                                <a href="{{ $item->getUrl() }}" data-lightbox="{{ $motorcycle->id }}" data-title="{{ $title }}"
                                   class="img-widget img-widget-md"
                                >
                                    <img src="{{ $item->getUrl('thumb') }}" alt="{{ $title }}">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
