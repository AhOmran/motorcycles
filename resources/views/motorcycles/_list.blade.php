@foreach($motorcycles as $motorcycle)
    <div class="card">
        @if(auth()->id() == $motorcycle->user_id)
            <div class="buttons clearfix">
                <a href="{{ route('motorcycles.edit', $motorcycle->id) }}" class="btn btn-primary btn-xs">
                    <i class="fa fa-edit fa-fw" aria-hidden="true"></i> Edit
                </a>
                <a href="#" data-url="{{ route('motorcycles.destroy', $motorcycle->id) }}" data-method="DELETE" class="btn btn-danger btn-xs">
                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i> Delete
                </a>
            </div>
        @endif

        <div class="row">
            <div class="col-md-7">
                <h2 class="title">
                    <a href="{{ route('motorcycles.show', $motorcycle->id) }}">{{ $motorcycle->title }}</a>
                </h2>
                <p class="description">{{ str_limit($motorcycle->description, 100) }}</p>
                <p class="phone-number">Call seller at: {{ $motorcycle->phone_number }}</p>

                @if($motorcycle->sold)
                    <span class="label label-primary">Sold</span>
                @endif
            </div>
            <div class="col-md-5">
                <div class="images">
                    @foreach($motorcycle->media as $item)
                        @php $title = $motorcycle->title . ' | Image ' . $loop->iteration @endphp

                        <a href="{{ $item->getUrl() }}" data-lightbox="{{ $motorcycle->id }}" data-title="{{ $title }}">
                            <img src="{{ $item->getUrl('thumb') }}" alt="{{ $title }}">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach

{!! $motorcycles->links() !!}