@extends('layouts.app')

@section('hero')
    <section class="hero lazy" data-src="@asset('images/common/hero-bg.png')">
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase is-size-1 is-size-4-mobile has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {!! woocommerce_breadcrumb() !!}
    <hr>
    @php(woocommerce_content())
@endsection