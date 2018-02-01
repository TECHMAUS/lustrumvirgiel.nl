@extends('layouts.app')

@section('hero')
    <section class="hero is-medium lazy" @if(get_the_post_thumbnail_url()) data-src="{{ the_post_thumbnail_url($size = 'large') }}" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase has-word-wrap z-depth-1 is-size-1 is-size-3-touch has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    @if(defined('ADROTATE_VERSION'))
        <div class="has-text-centered ggvhl">
            {!! adrotate_group(4) !!}
        </div>
    @endif

    @while(have_posts()) @php(the_post())
            @include('partials.content-single')
    @endwhile

    @if(!get_field('disable_fb_comments'))
    <div class="fb-comments" data-href="{{ App::currentUrl() }}" data-width="100%" data-numposts="10" data-order-by="social" data-colorscheme="dark"></div>
    @endif

@endsection

@section('sidebar')
    <div class="quick-facts">
        <div class="card">
            <div class="card-content">
                <div class="content is-uppercase has-text-weight-bold">
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/calendar.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Laatste update: </span><time datetime="{{ get_post_time('c') }}">{{ get_the_date() }}, {{  get_the_time() }} uur</time></p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/author.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Door: </span>{{ get_the_author() }}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/mail.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Reageren: </span> <a class="has-text-white has-word-wrap" href="mailto:{{ antispambot(the_author_meta($field = 'user_email')) }}">{{ antispambot($field = the_author_meta('user_email')) }}</a></p></div>
                    @if(get_the_tags()) <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/category.svg')')"></span> <p>{{ the_tags( '<span class="tag is-light has-word-wrap">', '</span><span class="tag is-light has-word-wrap">', '</span>' ) }}</p></div> @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.social-share-buttons')

    @if(defined('ADROTATE_VERSION'))
        <div class="has-text-centered ggvhl">
            {!! adrotate_group(3) !!}
        </div>
    @endif

    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection