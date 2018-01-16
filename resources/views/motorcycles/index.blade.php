@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="page-header">Motorcycles</h1>

                @include('motorcycles._list')
            </div>
        </div>
    </div>
@endsection
