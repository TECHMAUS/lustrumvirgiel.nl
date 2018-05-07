<div class="entry-meta">
  @if(is_sticky() && (is_front_page() || is_home() || is_search() ))
    <div class="meta-item is-pulled-right">
      <span class="tag is-danger has-sticky-tag has-text-weight-bold is-medium is-uppercase z-depth-2">Uitgelicht!</span>
    </div>
  @endif
  <div class="meta-item">
    <span class="icon is-small" style="background-image:url('@asset('images/news-entry/calendar.svg')')"></span>
    <time class="updated is-uppercase has-text-weight-bold" datetime="{{ get_post_time('c') }}">{{ get_the_date() }}</time>
  </div>
    @if(! empty(get_the_category()))
      <div class="meta-item">
        <span class="icon is-small" style="background-image:url('@asset('images/news-entry/category.svg')')"></span>
        <span>
            {!! get_the_category_list(',&#32;')  !!}
        </span>
      </div>
    @endif
</div>

