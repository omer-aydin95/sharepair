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
                      <h2>Rate Appointment</h2>
                    </header>
                    <p>Study Topic: {{$app->GetContent()}}</p>
                    <p>Study Pair: <?php echo '<a href="user?id=' . $user->GetID() . '">' . $user->GetName() . ' ' . $user->GetSurname() . '</a>'; ?> </p>
                    <p>Study Date: {{$app->GetDate()}}</p>
                    <p>Study Place: {{$place->GetName()}}, {{$place->GetDepartment()}}, {{$place->GetFloor()}}, {{$place->GetMaxCapacity()}}</p>

                    <form method="post" action="" id="idsendmform">

                      {{ csrf_field() }}
                      <?php echo '<input type="hidden" name="appid" value="' . $app->GetID() . '">' ?>

                      <div class="row uniform">
                        <div class="12u$(xsmall)"><p style="line-height: 35px;">Rate:</p></div>
                        <div class="6u$ 12u$(xsmall)">
                          <div class="select-wrapper">
                            <select title="Select a point that you want to give this completed appointment." name="rate">
                              <option>0</option>
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                            </select>
                          </div>
                        </div>
                        <div class="12u$">
                          <ul class="actions">
                            <li><input type="submit" value="Rate" class="special" /></li>
                          </ul>
                        </div>
                      </div>
                    </form>
                  </div>
                </section>
@endsection


@section('footjs')

@endsection





















































