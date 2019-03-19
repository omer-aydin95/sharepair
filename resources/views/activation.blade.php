@extends('template')


@section('headjs')

@endsection


@section('css')

@endsection


@section('content')
              <!-- Banner -->
                <section id="banner">
                  <div class="content">
                    <header>
                      <h2>Account Activation</h2>
                    </header>
                      <div class="row uniform">
                        <div class="6u$ 12u$(xsmall)">
                          {{$message}}
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <a href=<?php echo '"' . $link . '"'; ?> class="button default">{{$button}}</a>
                        </div>
                      </div>
                  </div>
                </section>
@endsection


@section('footjs')

@endsection












































