@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('motorcycles.update', $motorcycle->id) }}" method="POST" enctype="multipart/form-data" id="formMotorcycle">
            <h1 class="page-header">Edit Motorcycle: {{ $motorcycle->title }}</h1>

            {!! method_field('PATCH') !!}

            @include('motorcycles._form')
        </form>
    </div>
@endsection
