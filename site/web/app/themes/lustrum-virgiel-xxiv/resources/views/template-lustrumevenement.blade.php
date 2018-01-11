{{--
  Template Name: Lustrumevenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero" @if(get_the_post_thumbnail_url()) style="background: url('{{ the_post_thumbnail_url() }}') center center;" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
                <h2 class="is-uppercase is-size-4 has-text-weight-bold has-text-centered-mobile">{{ the_field('event_subtitle') }}</h2>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="dropcap has-text-justified">
        @while(have_posts()) @php(the_post())
                @include('partials.content-page')
        @endwhile
    </div>
@endsection

@section('sidebar')
    <div class="quick-facts">
        <div class="card">
            <div class="card-content">
                <div class="content is-uppercase has-text-weight-bold">
                    @if(App::days_until() > 0) <div class="fact tag is-light is-medium">Nog<span style="text-decoration: underline; margin: 0 3px;">{{ App::days_until() }}</span>nachtjes slapen!</div> @endif
                    @if(App::days_until() == 0) <div class="fact tag is-light is-medium">Vandaag!</div> @endif
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/1d-icon.svg')')"></span> <p>{{ the_field('quick_facts_1d') }}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/2d-icon.svg')')"></span> <p>{{ the_field('quick_facts_2d') }}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/3d-icon.svg')')"></span> <p>{{ the_field('quick_facts_3d') }}</p></div>
                    <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/4d-icon.svg')')"></span> @php($user = get_field('quick_facts_4d')) <a class="has-text-white has-word-wrap" href="mailto:{{ antispambot($user['user_email']) }}">{{ antispambot($user['user_email']) }}</a> </div>
                </div>
            </div>
        </div>
    </div>
    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection