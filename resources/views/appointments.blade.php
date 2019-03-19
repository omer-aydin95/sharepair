<?php

  $total_page = ceil($total / 10);

?>


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
                      <h2>Appointments</h2>
                    </header>
                    <form action="" method="post">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="12u$(xsmall)">
                          <input type="text" title="Search something in your appointments." name="search" id="idsearch" value="{{rawurldecode($search)}}" placeholder="Search" />
                        </div>
                        <div class="12u$(xsmall)">
                          <ul class="actions" style="text-align: center;">
                            <li><input type="submit" value="Search" name="btnsearch" class="special" /></li>
                          </ul>
                        </div>
                        <div class="12u$(xsmall)">
                          <div class="select-wrapper">
                            <select name="sort" title="Display your appointments with some options." id="idsort" onchange="window.location='appointments?page={{$page}}&show='+this.value+'&search={{$search}}'" >
                              <option value="all" <?php if($show == 'all') echo 'selected'; ?> >All</option>
                              <option value="completed" <?php if($show == 'completed') echo 'selected'; ?> >Completed</option>
                              <option value="accepted" <?php if($show == 'accepted') echo 'selected'; ?> >Accepted</option>
                              <option value="unanswered" <?php if($show == 'unanswered') echo 'selected'; ?> >Unanswered</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <div class="table-wrapper">
                        <table>
                          <thead>
                            <tr>
                              <th style="min-width: 40px;">#</th>
                              <th style="min-width: 256px;">Study Topic</th>
                              <th style="min-width: 128px;">With</th>
                              <th style="min-width: 128px;">Study Date</th>
                              <th style="min-width: 128px;">Study Place</th>
                              <th style="min-width: 110px;">
                                <ul class="icons" style="height: 0px;">
                                  <li class="icon fa-cog"></li>
                                </ul>
                              </th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php

                              for($i = 0; $i < $current_total; $i++)
                              {
                                echo
                                '<tr>
                                  <td style="font-weight: bold;">' . strval((($page - 1) * 10) + ($i + 1)) . '</td>
                                  <td>' . $apps[$i]->GetContent() . '</td>
                                  <td><a href="user?id=' . $users[$apps[$i]->GetID()]->GetID() . '">' . $users[$apps[$i]->GetID()]->GetName() . ' ' . $users[$apps[$i]->GetID()]->GetSurname() . '</a></td>
                                  <td>' . $apps[$i]->GetDate() . '</td>
                                  <td>' . $places[$apps[$i]->GetID()]->GetName() . ', ' . $places[$apps[$i]->GetID()]->GetDepartment() . ', ' . $places[$apps[$i]->GetID()]->GetFloor() . ', ' . $places[$apps[$i]->GetID()]->GetMaxCapacity() . '</td>
                                  <td>';

                                  if($apps[$i]->GetAccepted() == -2)
                                  {
                                    echo
                                    '<ul class="actions">
                                      <li><input type="submit" value="Delete" name="' . $apps[$i]->GetID() . '" title="Delete this cancelled appointment." class="special" /></li>';
                                  }
                                  else if($apps[$i]->GetAccepted() == 0 && $apps[$i]->GetCompleted() == 0 && $apps[$i]->GetSentByOwner() == 0)
                                  {
                                    echo
                                    '<ul class="actions">
                                      <li><input type="submit" value="Accept" name="' . $apps[$i]->GetID() . '" title="Accept this appointment." class="special" /></li><br><br>
                                      <li><input type="submit" value="Cancel" name="' . $apps[$i]->GetID() . '" title="Cancel this appointment." class="special" /></li>';
                                  }
                                  else if($apps[$i]->GetAccepted() == 0 && $apps[$i]->GetCompleted() == 0 && $apps[$i]->GetSentByOwner() == 1)
                                  {
                                    echo
                                    '<ul class="actions">
                                      <li><input type="submit" value="Cancel" name="' . $apps[$i]->GetID() . '" title="Cancel this appointment." class="special" /></li>';
                                  }
                                  else if($apps[$i]->GetAccepted() == 1 && $apps[$i]->GetCompleted() == 0 && $apps[$i]->GetSentByOwner() == 0)
                                  {
                                    echo
                                    '<ul class="actions">
                                      <li><input type="submit" value="Cancel" name="' . $apps[$i]->GetID() . '" title="Cancel this appointment." class="special" /></li>';
                                  }
                                  else if($apps[$i]->GetAccepted() == 1 && $apps[$i]->GetCompleted() == 0 && $apps[$i]->GetSentByOwner() == 1)
                                  {
                                    echo
                                    '<ul class="actions">
                                      <li><a href="rate-appointment?id=' . $apps[$i]->GetID() . '" title="Rate / give point to this completed appointment." class="button">Rate It</a></li><br><br>
                                      <li><input type="submit" value="Cancel" name="' . $apps[$i]->GetID() . '" title="Cancel this appointment." class="special" /></li>';
                                  }
                                  else if($apps[$i]->GetAccepted() == 1 && $apps[$i]->GetCompleted() == 1 && ($apps[$i]->GetSentByOwner() == 0 || $apps[$i]->GetSentByOwner() == 1))
                                  {
                                    echo
                                    '<ul title="Appointment rate / point." class="icons">';

                                    for($j = 0; $j < $apps[$i]->GetPoint(); $j++)
                                    {
                                      echo
                                      '<li class="icon fa-star" style="padding: 0"></li>';
                                    }
                                  }

                                  echo
                                  '   </ul>
                                    </td>
                                  </tr>';
                              }

                            ?>

                          </tbody>
                        </table>
                      </div>
                    </form>
                    <ul class="pagination" style="text-align: center;">
                      <?php

                        if($total_page == 0)
                        {
                          echo
                          '<li><a href="" title="Previous page." class="button disabled">Prev</a></li>
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else if($total_page == 1)
                        {
                          echo
                          '<li><a href="" title="Previous page." class="button disabled">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else if($page == 1)
                        {
                          echo
                          '<li><a href="" title="Previous page." class="button disabled">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="appointments?page=' . strval($page + 1) . '&show=' . $show . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }
                        else if($page == $total_page)
                        {
                          echo
                          '<li><a href="appointments?page=' . strval($page - 1) . '&show=' . $show . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else
                        {
                          echo
                          '<li><a href="appointments?page=' . strval($page - 1) . '&show=' . $show . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="appointments?page=' . strval($page + 1) . '&show=' . $show . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }

                      ?>
                    </ul>
                  </div>
                </section>
@endsection


@section('footjs')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
  <script src="/js/sweetalert2.all.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="http://malsup.github.io/min/jquery.form.min.js"></script>
  <script src="http://malsup.github.com/jquery.form.js"></script>
  <script src="/js/jquery.validate.min.js"></script>
  <script src="/js/additional-methods.min.js"></script>
  <script src="/js/messages_tr.min.js"></script>

  <script>

    $(document).ready(
      function()
      {
        $('#idloginform').ajaxForm({
          success:function(response)
          {
            if(response.status == "success")
              window.location = "profile";
            else
              swal(response.title, response.content, response.status);
          }
        });
      }
    );

  </script>

@endsection












































