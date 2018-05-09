<div class="quick-facts">
    @if($days_until_event >= 0)
        <div class="has-text-right">
            <div class="counter">
                <div class="days">
                    <span class="has-text-weight-bold">{!! $days_until_event !!}</span>
                </div>
                <div class="text has-text-left bigtext">
                    @if($days_until_event == 1)
                        <span class="is-uppercase">Nachtje</span>
                    @else
                        <span class="is-uppercase">Nachtjes</span>
                    @endif
                    <span class="is-uppercase">Slapen</span>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-content">
            <div class="content is-uppercase has-text-weight-bold">
                <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/1d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Datum & tijd:</span>{!! $quick_facts_date !!} </p></div>
                <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/2d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Locatie: </span>{!! the_field('quick_facts_2d') !!}</p></div>
                <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/3d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Kaarten: </span>{!! $ticket_fact !!}</p></div>
                <div class="fact title-has-icon"><span class="icon" style="background-image:url('@asset('images/common/4d-icon.svg')')"></span> <p class="has-subtitle"><span class="is-size-7">Contact: </span><a class="has-text-white has-word-wrap" href="mailto:{{ App::authorEmail() }}">{{ App::authorEmail() }}</a></p> </div>
            </div>
        </div>
    </div>
</div>

<div class="social-share">
    @if(!get_field('sold_out'))
        <a  href="{!! the_field('tickets_url', TemplateLustrumsubevenement::parentPageID()) !!}"
            class="share-button tickets button z-depth-1 mdi mdi-ticket mdi-rotate-315 is-uppercase"
            target="_blank"
            rel="noopener">
            Tickets
        </a>
    @endif
    @if(!empty(the_field('fb_event_url')))
        <a href="{!! the_field('fb_event_url') !!}"
           class="share-button facebook button z-depth-1 mdi mdi-facebook is-uppercase"
           target="_blank"
           rel="noopener">
            Event
        </a>
    @endif
</div>