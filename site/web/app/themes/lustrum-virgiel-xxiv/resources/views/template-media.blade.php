{{--
  Template Name: Media
--}}

@extends('layouts.app')

@section('content')
    @include('partials.page-header')
    <div class="level">
        <div class="level-left">
            {{  App::wps_yoast_breadcrumb_bulma() }}
        </div>

        <div class="level-right">
            @if(defined('ADROTATE_VERSION'))
                {!! adrotate_group(2) !!}
            @endif
        </div>
    </div>

    @while(have_posts()) @php(the_post())
    @include('partials.content-page')
    @endwhile
@endsection