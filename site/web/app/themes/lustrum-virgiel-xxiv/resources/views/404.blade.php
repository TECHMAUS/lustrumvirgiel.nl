@extends('layouts.app')

@section('hero')
  <section class="hero lazy" data-src="@asset('images/common/hero-bg.png')">
    <div class="hero-body">
      <div class="container">
        <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
      </div>
    </div>
  </section>
@endsection

@section('content')

  @if (!have_posts())
    <div class="warning has-text-centered is-uppercase has-text-weight-bold">
      <p class="is-size-4">Ohnee! Je bent verdwaald geraakt in de 4e Dimensie. <br>
        Wat je zocht kun je hier niet vinden, we raden je aan om terug te gaan naar de <a href="{{  home_url() }}">homepage</a>!</p>
      {!! get_search_form(false) !!}
    </div>

    <div class="columns is-vcentered is-multiline">

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:56%;position:relative;"><iframe src="https://giphy.com/embed/Td7XefcJiu3IY" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/first-doctor-Td7XefcJiu3IY"></a></p></div>

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:56%;position:relative;"><iframe src="https://giphy.com/embed/l0Iyh3gFEvueA6guI" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/RJFilmSchool-arcade-videogame-l0Iyh3gFEvueA6guI"></a></p>
      </div>

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:50%;position:relative;"><iframe src="https://giphy.com/embed/l3vR1BABQ24VVv4mA" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/doctor-who-bbc-drama-l3vR1BABQ24VVv4mA"></a></p>
      </div>

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:75%;position:relative;"><iframe src="https://giphy.com/embed/3o7qE8OqOlUhffQfxm" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/vhs-positive-vhspositive-3o7qE8OqOlUhffQfxm"></a></p></div>

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:93%;position:relative;"><iframe src="https://giphy.com/embed/ToMjGpBmDyMmBrMmbf2" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/cheezburger-panda-ToMjGpBmDyMmBrMmbf2"></a></p></div>

      <div class="column is-one-third">
        <div style="width:100%;height:0;padding-bottom:56%;position:relative;"><iframe src="https://giphy.com/embed/L3pfVwbsJbrk4" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div><p><a href="https://giphy.com/gifs/disney-star-wars-darth-vader-L3pfVwbsJbrk4"></a></p></div>

    </div>

  @endif
@endsection
