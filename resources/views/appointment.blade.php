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
                      <h2>
                        
                        <?php

                          if($app->GetAccepted() == -2)
                            echo 'Canceled Appointment Details';
                          else if($app->GetAccepted() == 1)
                            echo 'Accepted Appointment Details';
                          else
                            echo 'Appointment Details';

                        ?>

                      </h2>
                    </header>
                    @if($emp == 1)
                    <p>Study Topic: {{$app->GetContent()}}</p>
                    <p>Study Pair: <?php echo '<a href="user?id=' . $user->GetID() . '">' . $user->GetName() . ' ' . $user->GetSurname() . '</a>'; ?> </p>
                    <p>Study Date: {{$app->GetDate()}}</p>
                    <p>Study Place: {{$place->GetName()}}, {{$place->GetDepartment()}}, {{$place->GetFloor()}}, {{$place->GetMaxCapacity()}}</p>
                    <form method="post" action="" id="idsendmform">

                      {{ csrf_field() }}
                      <?php echo '<input type="hidden" name="appid" value="' . $app->GetID() . '">' ?>

                      <div class="row uniform">
                        <div class="12u$">
                          <ul class="actions">
                            <?php

                              if($app->GetAccepted() == -2)
                              {
                                echo
                                '<li><input type="submit" title="Delet this cancelled appointment." value="Delete" class="special" /></li>';
                              }

                            ?>
                          </ul>
                        </div>
                      </div>
                    </form>
                    @endif
                  </div>
                </section>
@endsection


@section('footjs')

@endsection





















































