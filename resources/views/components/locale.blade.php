<form action="{{route('setLocale', $lang)}}" method="GET"> 
    {{--  --}}
    <button type="submit" class="btn d-inline-flex align-items-center justify-content-center px-2 mx-auto">
        <img src="{{ asset('vendor/blade-flags/language-' . $lang . '.svg')}}" alt="" width="16" height="16" class="d-inline-block me-2"> 
        <span class="text-uppercase">{{ $lang }}</span>
    </button>
</form>