<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials._head')
<body>
    <div id="app">
        @include('layouts.partials._navbar')

        @yield('content')
    </div>

    @include('layouts.partials._scripts')
</body>
</html>
