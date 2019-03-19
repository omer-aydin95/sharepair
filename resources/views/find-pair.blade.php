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
                      <h2>Find a Pair</h2>
                    </header>
                    <form action="" method="post">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="12u$(xsmall)">
                          <input type="text" value="{{rawurldecode($search)}}" name="search" title="Search something in students who want teach some topics." id="idsearch" placeholder="Search" />
                        </div>
                        <div class="12u$(xsmall)">
                          <ul class="actions" style="text-align: center;">
                            <li><input type="submit" value="Search" class="special" /></li>
                          </ul>
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <div class="select-wrapper">
                            <select name="sort" title="Sort students." id="idsort" onchange="window.location='find-pair?page={{$page}}&sort='+this.value+'&search={{$search}}'" >
                              <option value="u_asc" <?php if($sort == 'u_asc') echo 'selected'; ?> >User (ascending order)</option>
                              <option value="u_desc" <?php if($sort == 'u_desc') echo 'selected'; ?> >User (descending order)</option>
                              <option value="g_asc" <?php if($sort == 'g_asc') echo 'selected'; ?> >Grade (ascending order)</option>
                              <option value="g_desc" <?php if($sort == 'g_desc') echo 'selected'; ?> >Grade (descending order)</option>
                              <option value="d_asc" <?php if($sort == 'd_asc') echo 'selected'; ?> >Department (ascending order)</option>
                              <option value="d_desc" <?php if($sort == 'd_desc') echo 'selected'; ?> >Department (descending order)</option>
                              <option value="p_asc" <?php if($sort == 'p_asc') echo 'selected'; ?> >Overall Point (ascending order)</option>
                              <option value="p_desc" <?php if($sort == 'p_desc') echo 'selected'; ?> >Overall Point (descending order)</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="table-wrapper">
                      <table>

                        <?php

                          for($i = 0; $i < $current_total; $i++)
                          {
                            echo
                            '<tr>
                              <td><a href="user?id=' . $users[$i]->GetID() . '">' . $users[$i]->GetName() . ' ' . $users[$i]->GetSurname() . '</a></td>
                              <td style="min-width: 256px;">' . $users[$i]->GetAbout() . '</td>
                              <td style="min-width: 100px;">' . $users[$i]->GetGrade() . '</td>
                              <td>' . $users[$i]->GetDepartment() . '</td>
                              <td style="min-width: 110px;">
                                <ul class="icons">';

                            for($j = 0; $j < $points[$users[$i]->GetID()]; $j++)
                            {
                              echo
                              '   <li class="icon fa-star" style="padding: 0;"></li>';
                            }

                            echo
                            '   </ul>
                              </td>';
                            
                            if($users[$i]->GetID() != Session('user')->GetID())
                            {
                            echo
                              '<td>
                                <ul class="icons">
                                  <li><a href="send-r?id=' . $users[$i]->GetID() . '" title="Send a study request to the student." class="button icon fa-paper-plane"></a></li><br><br>
                                  <li><a href="send-m?id=' . $users[$i]->GetID() . '" title="Send a message to the student." class="button icon fa-envelope"></a></li>
                                </ul>
                              </td>';
                            }
                            
                            echo
                            '</tr>';
                          }

                        ?>
                        
                      </table>
                    </div>
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
                           <li><a href="find-pair?page=' . strval($page + 1) . '&sort=' . $sort . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }
                        else if($page == $total_page)
                        {
                          echo
                          '<li><a href="find-pair?page=' . strval($page - 1) . '&sort=' . $sort . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else
                        {
                          echo
                          '<li><a href="find-pair?page=' . strval($page - 1) . '&sort=' . $sort . '&search=' . $search . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="find-pair?page=' . strval($page + 1) . '&sort=' . $sort . '&search=' . $search . '" title="Next page." class="button">Next</a></li>';
                        }

                      ?>

                    </ul>
                  </div>
                </section>
@endsection


@section('footjs')

@endsection












































