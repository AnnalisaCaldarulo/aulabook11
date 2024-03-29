<div class="card text-white card-has-bg position-relative"
    style="background-image:url({{ $cover ? Storage::url($cover) : '/header-image.png' }});">
    <a class="text-white text-decoration-none" href="{{ $url }}">
        <div class="card-img-overlay d-flex flex-column">
            <div class="card-body">
                <h4 class="card-title mt-0 ">{!! $title !!}</h4>
                <small>{!! $description !!}</small>
            </div>
            <div class="card-footer">
                <div class="media">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="my-0 text-white">{{ $author }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
