@extends('layouts.app')

@section('hero')
    <section class="hero is-medium" @if(get_the_post_thumbnail_url()) style="background-image: url('{{ the_post_thumbnail_url($size = 'large') }}')" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase is-size-1 has-text-centered-mobile has-text-weight-bold">{!! App::title() !!}</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    @while(have_posts()) @php(the_post())
            @include('partials.content-single')
    @endwhile
@endsection

@section('sidebar')
    <div class="quick-facts">
        <div class="card">
            <div class="card-content">
                <div class="content is-uppercase has-text-weight-bold">
                    @if(App::days_until() > 0) <div class="fact tag is-light is-medium">Nog<span style="text-decoration: underline; margin: 0 3px;">{{ App::days_until() }}</span>nachtjes slapen!</div> @endif
                    @if(App::days_until() == 0) <div class="fact tag is-light is-medium">Vandaag!</div> @endif
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/calendar.svg')')"></span> <p><time datetime="{{ get_post_time('c') }}">{{ get_the_date() }}, {{  get_the_time() }} uur</time></p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/author.svg')')"></span> <p>{{ get_the_author() }}</p></div>
                    @if(get_the_tags()) <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/category.svg')')"></span> <p>{{ the_tags( '<span class="tag is-light">', '</span><span class="tag">', '</span>' ) }}</p></div> @endif
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/news-entry/mail.svg')')"></span> <p><span class="is-size-7">Reageren: </span> <a class="has-text-white has-word-wrap" href="mailto:{{ antispambot(the_author_meta($field = 'user_email')) }}">{{ antispambot($field = the_author_meta('user_email')) }}</a></p></div>
                </div>
            </div>
        </div>
    </div>
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection