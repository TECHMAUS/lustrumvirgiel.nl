@if(!empty(get_field('action_banner_text')))
    <section class="section action-banner lazy" data-src="@asset('images/front-page/lustrum_pattern.svg')">
        <div class="wrap container">
            <div class="level has-text-centered">
                <h3 class="is-size-4 is-size-5-mobile has-text-white is-uppercase has-text-weight-bold level-left {!! App::pageSlug() !!}-background">{{ the_field('action_banner_text') }}</h3>
                <a href="{{ the_field('action_banner_button-url') }}" class="button is-medium is-uppercase level-right button-{!! App::pageSlug() !!} has-shadow z-depth-1 hoverable">{{ the_field('action_banner_button-text') }}</a>
            </div>
        </div>
    </section>
@endif