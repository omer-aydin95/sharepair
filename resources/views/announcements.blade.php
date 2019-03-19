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
                      <h2>Announcements</h2>
                    </header>
                    <form action="" method="post">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="12u$(xsmall)">
                          <input type="text" value="{{rawurldecode($search)}}" title="Search something in study announcements." name="search" id="idsearch" placeholder="Search" />
                        </div>
                        <div class="12u$(xsmall)">
                          <ul class="actions" style="text-align: center;">
                            <li><input type="submit" value="Search" name="btnsearch" class="special" /></li>
                          </ul>
                        </div>
                        <div class="12u$(xsmall)">
                          <div class="select-wrapper">
                            <select name="sort" title="Sort study announcements." id="idsort" onchange="window.location='announcements?page={{$page}}&sort='+this.value+'&show={{$show}}&search={{$search}}'" >
                              <option value="o_asc" <?php if($sort == 'o_asc') echo 'selected'; ?> >Announcements Owner (ascending order)</option>
                              <option value="o_desc" <?php if($sort == 'o_desc') echo 'selected'; ?> >Announcements Owner (descending order)</option>
                              <option value="a_asc" <?php if($sort == 'a_asc') echo 'selected'; ?> >Total Answer (ascending order)</option>
                              <option value="a_desc" <?php if($sort == 'a_desc') echo 'selected'; ?> >Total Answer (descending order)</option>
                            </select>
                          </div>
                        </div>
                        <div class="12u$">
                          <input type="checkbox" <?php if($show == 'me') echo 'checked'; ?> id="idallme" name="allme" onchange="AllOrMe(this)" >
                          <label for="idallme">Show my announcements</label>
                        </div>
                      </div>
                      <br>
                      <div class="table-wrapper">
                        <table>
                          <thead>
                            <tr>
                              <th>Study Topic</th>
                              <th>Announcement Owner</th>
                              <th style="min-width: 128px;">Study Date</th>
                              <th>Study Place</th>
                              <th>Total Replied</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php

                            for($i = 0; $i < $current_total; $i++)
                            {
                              echo
                              '<tr>
                                <td>' . $annos[$i]->GetContent() . '</td>
                                <td><a href="user?id=' . $users[$annos[$i]->GetOwnerUser()]->GetID() . '">' . $users[$annos[$i]->GetOwnerUser()]->GetName() . ' ' . $users[$annos[$i]->GetOwnerUser()]->GetSurname() . '</a></td>
                                <td>' . $annos[$i]->GetDate() . '</td>
                                <td>
                                ' . $places[$annos[$i]->GetPlace()]->GetName() . ', ' . $places[$annos[$i]->GetPlace()]->GetDepartment() . ', ' . $places[$annos[$i]->GetPlace()]->GetFloor() . ', Max Cap: ' . $places[$annos[$i]->GetPlace()]->GetMaxCapacity() . '
                                </td>
                                <td>Replied: ' . $annos[$i]->GetReplied() . '</td>';

                              if($annos[$i]->GetOwnerUser() == Session::get('user')->GetID())
                                echo
                                '<td>
                                  <ul class="actions" style="text-align: center;">
                                    <li><input type="submit" name="' . $annos[$i]->GetID() . '" title="Cancel this your study announcement." value="Cancel" class="special" /></li>
                                  </ul>
                                </td>
                              </tr>';
                              else
                                echo
                                '<td>
                                  <ul class="actions" style="text-align: center;">
                                    <li><input type="submit" name="' . $annos[$i]->GetID() . '" title="Answer this study announcement." value="Answer" class="special" /></li>
                                  </ul>
                                </td>
                              </tr>';
                            }

                          ?>
                          
                          </tbody>
                        </table>
                      </div>
                    </form>
                    <br>
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
                           <li><a href="announcements?page=' . strval($page + 1) . '&sort=' . $sort . '&show='. $show . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }
                        else if($page == $total_page)
                        {
                          echo
                          '<li><a href="announcements?page=' . strval($page - 1) . '&sort=' . $sort . '&show='. $show . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else
                        {
                          echo
                          '<li><a href="announcements?page=' . strval($page - 1) . '&sort=' . $sort . '&show='. $show . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="announcements?page=' . strval($page + 1) . '&sort=' . $sort . '&show='. $show . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }

                      ?>
                    </ul>
                  </div>
                </section>
@endsection


@section('footjs')

  <script>
    function AllOrMe(cb)
    {
      if(cb.checked)
        window.location = "announcements?page={{$page}}&sort={{$sort}}&show=me&search={{$search}}";
      else
        window.location = "announcements?page={{$page}}&sort={{$sort}}&show=all&search={{$search}}";
    }
  </script>

@endsection












































