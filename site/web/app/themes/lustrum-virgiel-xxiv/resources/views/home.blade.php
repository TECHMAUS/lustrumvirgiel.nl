@extends('layouts.app')

@section('content')
    @include('partials.page-header')

    @if (!have_posts())
        <div class="alert alert-warning">
            {{ __('Sorry, no results were found.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
    @endif

    <div class="columns is-multiline">
        @php($count = 0)
        @while (have_posts()) @php(the_post())
            @if($count == 0 )
                <div class="column is-full">
            @else
                <div class="column is-half">
            @endif
                  @include('partials.content')
                </div>
            @php($count++)
        @endwhile
    </div>

    {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection