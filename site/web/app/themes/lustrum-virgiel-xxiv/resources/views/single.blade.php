@extends('layouts.app')

@section('hero')
    <section class="hero is-medium lazy" @if(get_the_post_thumbnail_url()) data-src="{{ the_post_thumbnail_url($size = 'large') }}" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase has-word-wrap z-depth-1 is-size-5-mobile is-size-3-tablet is-size-1-desktop has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    <hr>

    @if(defined('ADROTATE_VERSION'))
        {!! adrotate_group(4) !!}
    @endif

    @while(have_posts()) @php(the_post())
        @include('partials.content-single')
    @endwhile

@endsection

@section('sidebar')
    <div class="quick-facts">
        <div class="card">
            <div class="card-content">
                <div class="content is-uppercase has-text-weight-bold">
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/calendar.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Geplaatst: </span><time datetime="{!! get_post_time('c', true) !!}">{!! $post_time !!} </time></p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/author.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Door: </span>{!! get_the_author() !!}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/mail.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Reageren: </span> <a class="has-text-white has-word-wrap" href="mailto:{{ App::authorEmail() }}">{{ App::authorEmail() }}</a></p></div>
                    @if(get_the_tags()) <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/category.svg')')"></span> <p>{!! the_tags( '<span class="tag is-light has-word-wrap">', '</span><span class="tag is-light has-word-wrap">', '</span>' ) !!}</p></div> @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.social-share-buttons')

    @if(defined('ADROTATE_VERSION'))
        {!! adrotate_group(3) !!}
    @endif

    @if($related_posts->have_posts())
        <section class="widget widget_related_posts">
            <hr>
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/3d-icon.svg')"></span> Gerelateerd</div></h3>

            @while($related_posts->have_posts())  @php($related_posts->the_post())
                @include('partials.content-related')
            @endwhile
            {{ wp_reset_postdata() }}

        </section>
    @endif

    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection