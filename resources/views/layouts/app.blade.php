<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials._head')
<body>
    <div id="app">
        @include('layouts.partials._navbar')


        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    @include('flash::message')
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    @include('layouts.partials._scripts')
</body>
</html>
