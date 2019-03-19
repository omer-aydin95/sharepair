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
                      <h2>Messages</h2>
                    </header>
                    <form action="" method="post" id="idmessform">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="6u$">
                          <div class="select-wrapper">
                            <select title="Sort the messages." name="sort" id="idsort" onchange="window.location='messages?page='+{{strval($page)}}+'&sort='+this.value">
                              <option value="d_asc" <?php if($sort == 'd_asc') echo 'selected'; ?> >Date (ascending order)</option>
                              <option value="d_desc" <?php if($sort == 'd_desc') echo 'selected'; ?> >Date (descending order)</option>
                              <option value="f_asc" <?php if($sort == 'f_asc') echo 'selected'; ?> >From (ascending order)</option>
                              <option value="f_desc" <?php if($sort == 'f_desc') echo 'selected'; ?> >From (descending order)</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <div class="table-wrapper">
                        <table>
                          <thead>
                            <tr>
                              <th style="width: 40px;">#</th>
                              <th>
                                <ul class="icons" style="height: 0px;">
                                  <li class="icon fa-check-square"></li>
                                </ul>
                              </th>
                              <th style="min-width: 256px;">Message</th>
                              <th style="min-width: 128px;">From</th>
                              <th style="min-width: 128px;">Date</th>
                              <th>
                                <ul class="icons" style="height: 0px;">
                                  <li class="icon fa-reply"></li>
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
                                  <td>
                                    <div class="6u$ 12u$(xsmall)">
                                      <input type="checkbox" id="idm' . strval($i + 1) . '" name="check_list[]" value="' . $mess[$i]->GetID() . '">
                                      <label for="idm' . strval($i + 1) . '"></label>
                                    </div>
                                  </td>
                                  <td>'. $mess[$i]->GetContent() . '</td>
                                  <td><a href="user?id=' . $users[$i]->GetID() . '">' . $users[$i]->GetName() . ' ' . $users[$i]->GetSurname() . '</a>
                                  </td>
                                  <td>' . $mess[$i]->GetDate() . '</td>
                                  <td>
                                    <ul class="actions">
                                      <li><a href="send-m?id=' . $users[$i]->GetID() . '" title="Reply this message." class="button default">Reply</a></li>
                                    </ul>
                                  </td>
                                </tr>';
                              }

                            ?>

                          </tbody>
                        </table>
                      </div>
                      <br>
                      <ul class="actions" style="text-align: center;">
                        <li><input type="submit" title="Delete the selected messages." id="iddel_sel" name="del_sel" value="Delete Selected" class="special" /></li>
                      </ul>
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
                           <li><a href="messages?page=' . strval($page + 1) . '&sort=' . $sort . '" title="Next page." class="button">Next</a></li>';
                        }
                        else if($page == $total_page)
                        {
                          echo
                          '<li><a href="messages?page=' . strval($page - 1) . '&sort=' . $sort . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else
                        {
                          echo
                          '<li><a href="messages?page=' . strval($page - 1) . '&sort=' . $sort . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="messages?page=' . strval($page + 1) . '&sort=' . $sort . '" title="Next page." class="button">Next</a></li>';
                        }

                      ?>

                    </ul>
                  </div>
                </section>
@endsection


@section('footjs')

@endsection












































