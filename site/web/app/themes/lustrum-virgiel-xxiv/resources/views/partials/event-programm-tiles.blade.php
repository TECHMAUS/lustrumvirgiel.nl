<div class="columns is-multiline is-mobile event-tiles">
    @while(have_rows('activiteiten')) @php(the_row())
    <div class="column is-one-third-mobile is-one-quarter-tablet">
        <a href="{!! get_permalink(TemplateLustrumevenement::activityPage()->ID) !!}">
            <div class="event-tile has-shadow z-depth-1">
                <div class="event-image lazy" data-src="{!! TemplateLustrumevenement::activityImage() !!}">
                </div>
                <div class="event-date">
                    <span class="font-fit">{!! TemplateLustrumevenement::activityDate(TemplateLustrumevenement::activityPage()) !!}</span>
                    <span class="font-fit">{!! TemplateLustrumevenement::activityMonth(TemplateLustrumevenement::activityPage()) !!}</span>
                </div>
                <div class="event-title">
                    <span class="font-fit">{!! TemplateLustrumevenement::activityTitle() !!}</span>
                </div>
                <div class="event-read-more has-text-black has-text-weight-bold">
                    <span class="is-size-7">Lees meer</span>
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="#000" d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" />
                    </svg>
                </div>
                @if(get_field('sold_out', TemplateLustrumevenement::activityPage()->ID))
                    <span class="sold-out is-uppercase has-text-weight-bold has-background-danger">Uitverkocht!</span>
                @endif
            </div>
        </a>
    </div>
    @endwhile
</div>