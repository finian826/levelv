@extends('layout.index')

@section('title', 'Welcome To ESIKnife')

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-3">
                <img src="{{ config('services.eve.urls.img') }}/Character/{{ Auth::user()->id }}_512.jpg" class="img-fluid rounded mx-auto d-block" />
            </div>
            <div class="col-lg-9">
                <h3>Welcome to {{ config('app.name') }} {{ Auth::user()->info->name }}</h3>
                <hr />
                <p>
                    {{ config('app.name') }} is a clone, fitting, and skill management application.
                </p>
                <h3 class="mb-1">Select the Scopes!</h3>
                <hr />
                @include('extra.alert')
                <form action="{{ route('welcome') }}" method="post">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-right">
                                        <a href="#" id="all">[Un/Select All]</a>
                                    </div>
                                    <strong>Character Information</strong>
                                </div>
                            </div>
                            <div class="accordian" id="accordian">
                                @foreach ($scopes as $scope)
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <label for="{{ $scope->get('key') }}" class="mt-2 mb-0">
                                                <input type="checkbox" id="{{ $scope->get('key') }}" name="scopes[{{ $scope->get('key') }}]" class="item" /> <span class="ml-2">{{ $scope->get('title') }}</span>
                                            </label>
                                            <button type="button" class="btn btn-secondary float-right" data-toggle="collapse" data-target="#{{ $scope->get('key') }}body">?</button>
                                        </div>

                                        <div id="{{ $scope->get('key') }}body" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                {{ $scope->get('desc') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary btn-lg">Authorize Selected Scopes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#all').on('click', function(){
            var checkboxes = $(':checkbox.item');
            checkboxes.prop('checked', !checkboxes.prop('checked'));
        });
    </script>
@endsection
