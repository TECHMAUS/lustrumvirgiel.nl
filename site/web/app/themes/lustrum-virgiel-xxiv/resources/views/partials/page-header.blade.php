<div class="page-header section-title title-has-icon">
    @if(get_field('page_icon'))
      <span class="icon is-medium" style="background-image:url('{{ the_field('page_icon') }}')"></span>
    @endif
    <h1>{!! App::title() !!}</h1>
</div>
