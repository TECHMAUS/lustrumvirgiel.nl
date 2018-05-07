<article @php(post_class('news-card')) data-tilt data-tilt-perspective="1200" data-tilt-scale="1.05">
  <div class="card">
    @if(get_the_post_thumbnail_url() && get_post_type() == 'post')
        <div class="card-image entry-image image is-2by1 lazy" data-src="{{ the_post_thumbnail_url() }}">
          @include('partials/entry-meta')
        </div>
    @endif
    <div class="card-content">
      <header>
        @if(!get_the_post_thumbnail_url() && get_post_type() == 'post')
          @include('partials/entry-meta')
        @endif
        <h2 class="entry-title"><a href="{{ the_permalink() }}" class="has-text-white is-uppercase has-text-weight-bold is-size-5">{{ the_title() }}</a></h2>
      </header>
      <div class="entry-summary has-text-justified">
        @php(the_excerpt())
      </div>
    </div>
  </div>
</article>
