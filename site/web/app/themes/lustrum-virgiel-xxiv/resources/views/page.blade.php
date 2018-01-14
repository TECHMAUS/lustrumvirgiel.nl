@extends('layouts.app')

@section('content')
    @include('partials.page-header')
    <div class="dropcap has-text-justified">
        @while(have_posts()) @php(the_post())
        @include('partials.content-page')
        @endwhile
    </div>
@endsection

@section('sidebar')
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection