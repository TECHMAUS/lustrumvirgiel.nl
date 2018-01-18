{{--
  Template Name: Media
--}}

@extends('layouts.app')

@section('content')
    @include('partials.page-header')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    @while(have_posts()) @php(the_post())
    @include('partials.content-page')
    @endwhile
@endsection