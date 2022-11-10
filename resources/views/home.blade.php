@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Carousel --}}
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner ">
                    @foreach($sliders as $slider)
                        <div class="carousel-item @if($loop->first) active @endif">
                            <div class="slider-image text-center">
                                <img src="{{  $slider }}" class="d-inline-block border text-center rounded" alt="{{ $slider }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>

        <section class="spacer yellow">
            <div class="container">
                <div class="row">
                    <div class="span6 alignright flyLeft">
                        <blockquote class="large">
                            La sala scherma resterà chiusa da venerdì 19 a lunedì 22 aprile.<cite>la Direzione</cite>
                        </blockquote>
                    </div>
                    <div class="span6 aligncenter flyRight">
                        <i class="icon-coffee icon-10x"></i>
                    </div>
                </div>
            </div>
        </section>

        <div class="col-md-8">
            <div class="h3 text-center pt-4">
                <span class="strong">
                    Attività del
                    <span style="color: #08699d;">Centro</span>
                </span>
            </div>
            <div class="row">
                <h2 class="owl-title" style="color:#111111;"></h2>
                <div class="owl-description" style="color:#666666;">Da circa 40 anni il C.S. Santa Maria propone corsi di insegnamento delle principali discipline sportive per adulti e bambini, secondo i programmi delle varie Federazioni sportive nazionali, seguiti da uno staff di tecnici altamente qualificati in un ambiente unico, moderno, tranquillo e funzionale.</div>
            </div>

        </div>
    </div>
</div>


@endsection
