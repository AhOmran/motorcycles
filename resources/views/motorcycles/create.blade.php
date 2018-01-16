@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('motorcycles.store') }}" method="POST" enctype="multipart/form-data" id="formMotorcycle">
            <h1 class="page-header">Add New Motorcycle</h1>

            @include('motorcycles._form')
        </form>
    </div>
@endsection
