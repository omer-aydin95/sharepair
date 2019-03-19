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
                      <h1>Welcome to SharePair</h1>
                      <p>The most innovative and effective way of learning.</p>
                    </header>

                    @if(!Session::exists('user'))
                    <p>Before join to SharePair please visit <a href="about">all about SharePair</a> then</p>
                    <ul class="actions">
                      <li><a href="login" class="button big">Login</a></li>
                      <li>or</li>
                      <li><a href="register" class="button big">Register</a></li>
                    </ul>
                    @endif
                    
                  </div>
                </section>

              <!-- Section -->
                <section>
                  <header class="major">
                    <h2>Overview</h2>
                  </header>
                  <div class="features">
                    <article>
                      <span class="icon fa-search"></span>
                      <div class="content">
                        <h3>Search for a Pair</h3>
                        <p>
                          Search and find a pair in your department or other departments in order to learn from him / her or teach to him / her a topic.
                        </p>
                      </div>
                    </article>
                    <article>
                      <span class="icon fa-user"></span>
                      <div class="content">
                        <h3>Create Your Profile</h3>
                        <p>
                          Create your own profile to tell about yourself to other students.
                        </p>
                      </div>
                    </article>
                    <article>
                      <span class="icon fa-calendar"></span>
                      <div class="content">
                        <h3>Manage Your Free Times</h3>
                        <p>
                          Manage your free times in order to find your pair easily.
                        </p>
                      </div>
                    </article>
                    <article>
                      <span class="icon fa-table"></span>
                      <div class="content">
                        <h3>Free Timetable</h3>
                        <p>
                          See other students' free timetables and send a study request according to that.
                        </p>
                      </div>
                    </article>
                    <article>
                      <span class="icon fa-building"></span>
                      <div class="content">
                        <h3>Find A Free Place</h3>
                        <p>
                          Find a free place in your school to study with your pair.
                        </p>
                      </div>
                    </article>
                    <article>
                      <span class="icon fa-star"></span>
                      <div class="content">
                        <h3>Give Points</h3>
                        <p>
                          Give points to your completed study appointments.
                        </p>
                      </div>
                    </article>
                  </div>
                </section>

                <ul class="actions" style="text-align: center;">
                  <li><a href="about" class="button big">Learn More</a></li>
                </ul>
@endsection


@section('footjs')

@endsection















































