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
                      <span class="image main" style="margin-left: 0; width: 192px; min-width: 192px; height: 192px; min-height: 192px;"> <?php echo '<img src="' . $user->GetPhoto() . '" />' ?> </span>
                      
                      <div class="row uniform">
                        <div class="12u$(xsmall)">
                          <h2>{{$user->GetName()}} {{$user->GetSurname()}}</h2>
                        </div>
                        <div>
                          <ul class="icons">
                            <li> <?php echo '<a href="send-m?id=' . $user->GetID() . '" title="Send a message to the student." class="button icon fa-envelope default"></a>' ?> </li>
                          </ul>
                        </div>
                        @if($user->GetWillTeach() == 1)
                        <div>
                          <ul class="icons">
                            <li> <?php echo '<a href="send-r?id=' . $user->GetID() . '" title="Send a study request to the student." class="button icon fa-paper-plane default"></a>' ?> </li>
                          </ul>
                        </div>
                        @endif
                      </div>
                    </header>
                    <br>
                    <ul class="icons" style="font-weight: bold;">
                      <table>
                        <tr>
                          <td class="icon fa-graduation-cap" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{$user->GetGrade()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-building" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{$user->GetDepartment()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-book" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{$user->GetAbout()}}</td>
                        </tr>
                        <tr>
                          <?php
                            if($user->GetWillTeach() == 1)
                              echo '<td class="icon fa-check" style="width: 32px; text-align: center;
                                    font-size: 18px;"></td>
                                    <td>I will teach some topics to other students</td>';
                            else
                              echo '<td class="icon fa-times" style="width: 32px; text-align: center;
                                    font-size: 18px;"></td>
                                    <td>I will not teach any topics to other students</td>';
                          ?>
                        </tr>
                      </table>
                    </ul>
                    <hr class="major" style="background-color: #f56a6a; height: 3px;" />
                    <h3>Free Timetable</h3>
                    <div class="table-wrapper">
                      <table>
                        <thead>
                          <tr>
                            <th style="text-align: center;">Hours</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date1']}} Monday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date2']}} Tuesday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date3']}} Wednesday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date4']}} Thursday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date5']}} Friday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date6']}} Saturday</th>
                            <th style="text-align: center;">{{Session::get('user_table')['date7']}} Sunday</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="font-weight: bold;">
                              09:30 - 10:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours1']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours1']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours2']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours2']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours3']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours3']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours4']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours4']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours5']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours5']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours6']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours6']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours7']['09:30-10:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['09:30-10:30']['free'] == 1 && Session::get('user_table')['hours7']['09:30-10:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              10:30 - 11:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours1']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours1']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours2']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours2']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours3']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours3']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours4']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours4']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours5']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours5']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours6']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours6']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours7']['10:30-11:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['10:30-11:30']['free'] == 1 && Session::get('user_table')['hours7']['10:30-11:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              11:30 - 12:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours1']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours1']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours2']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours2']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours3']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours3']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours4']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours4']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours5']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours5']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours6']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours6']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours7']['11:30-12:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['11:30-12:30']['free'] == 1 && Session::get('user_table')['hours7']['11:30-12:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              12:30 - 13:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours1']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours1']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours2']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours2']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours3']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours3']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours4']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours4']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours5']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours5']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours6']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours6']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours7']['12:30-13:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['12:30-13:30']['free'] == 1 && Session::get('user_table')['hours7']['12:30-13:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              13:30 - 14:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours1']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours1']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours2']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours2']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours3']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours3']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours4']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours4']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours5']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours5']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours6']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours6']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours7']['13:30-14:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['13:30-14:30']['free'] == 1 && Session::get('user_table')['hours7']['13:30-14:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              14:30 - 15:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours1']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours1']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours2']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours2']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours3']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours3']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours4']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours4']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours5']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours5']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours6']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours6']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours7']['14:30-15:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['14:30-15:30']['free'] == 1 && Session::get('user_table')['hours7']['14:30-15:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              15:30 - 16:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours1']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours1']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours2']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours2']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours3']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours3']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours4']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours4']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours5']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours5']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours6']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours6']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours7']['15:30-16:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['15:30-16:30']['free'] == 1 && Session::get('user_table')['hours7']['15:30-16:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              16:30 - 17:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours1']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours1']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours2']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours2']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours3']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours3']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours4']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours4']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours5']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours5']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours6']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours6']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours7']['16:30-17:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['16:30-17:30']['free'] == 1 && Session::get('user_table')['hours7']['16:30-17:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              17:30 - 18:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours1']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours1']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours2']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours2']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours3']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours3']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours4']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours4']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours5']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours5']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours6']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours6']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours7']['17:30-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['17:30-18:30']['free'] == 1 && Session::get('user_table')['hours7']['17:30-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                          <tr>
                            <td style="font-weight: bold;">
                              After 18:30
                            </td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours1']['after-18:30']['free'] == 1 && Session::get('user_table')['hours1']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours1']['after-18:30']['free'] == 1 && Session::get('user_table')['hours1']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours2']['after-18:30']['free'] == 1 && Session::get('user_table')['hours2']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours2']['after-18:30']['free'] == 1 && Session::get('user_table')['hours2']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours3']['after-18:30']['free'] == 1 && Session::get('user_table')['hours3']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours3']['after-18:30']['free'] == 1 && Session::get('user_table')['hours3']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours4']['after-18:30']['free'] == 1 && Session::get('user_table')['hours4']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours4']['after-18:30']['free'] == 1 && Session::get('user_table')['hours4']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours5']['after-18:30']['free'] == 1 && Session::get('user_table')['hours5']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours5']['after-18:30']['free'] == 1 && Session::get('user_table')['hours5']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours6']['after-18:30']['free'] == 1 && Session::get('user_table')['hours6']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours6']['after-18:30']['free'] == 1 && Session::get('user_table')['hours6']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                            <td align="center"
                              <?php
                                if(Session::get('user_table')['hours7']['after-18:30']['free'] == 1 && Session::get('user_table')['hours7']['after-18:30']['appointment'] == 0)
                                  echo 'style="background-image: url(\'images/tic.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                                else if(Session::get('user_table')['hours7']['after-18:30']['free'] == 1 && Session::get('user_table')['hours7']['after-18:30']['appointment'] == 1)
                                  echo 'style="background-image: url(\'images/cross.png\'); background-size: 45px 45px; background-position: center center; background-repeat: no-repeat;"';
                              ?>
                            ></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    @if($user->GetWillTeach() == 1)
                    <hr class="major" style="background-color: #f56a6a; height: 3px;" />
                    <h3>Completed Appointments</h3>
                    <div class="table-wrapper">
                      <table>
                        <thead>
                          <tr>
                            <th style="min-width: 40px;">#</th>
                            <th style="min-width: 256px;">Study Topic</th>
                            <th style="min-width: 128px;">Study Date</th>
                            <th style="min-width: 128px;">Study Place</th>
                            <th style="min-width: 110px;">Study Point</th>
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
                                <td>' . $apps[$i]->GetDate() . '</td>
                                <td>' . $places[$i] . '</td>
                                <td>
                                  <ul class="icons">';

                                for($j = 0; $j < $apps[$i]->GetPoint(); $j++)
                                {
                                  echo
                                  '<li class="icon fa-star" style="padding: 0"></li>';
                                }

                                echo
                                '</ul>
                                </td>
                               </tr>';
                            }

                          ?>

                        </tbody>
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
                           <li><a href="user?id=' . strval($user_id) . '&page=' . strval($page + 1) . '" title="Next page." class="button">Next</a></li>';
                        }
                        else if($page == $total_page)
                        {
                          echo
                          '<li><a href="user?id=' . strval($user_id) . '&page=' . strval($page - 1) . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="" title="Next page." class="button disabled">Next</a></li>';
                        }
                        else
                        {
                          echo
                          '<li><a href="user?id=' . strval($user_id) . '&page=' . strval($page - 1) . '" title="Previous page." class="button">Prev</a></li>
                           &nbsp;&nbsp;' . $page . '&nbsp;&nbsp;
                           <li><a href="user?id=' . strval($user_id) . '&page=' . strval($page + 1) . '" title="Next page." class="button">Next</a></li>';
                        }

                      ?>

                    </ul>
                    @endif
                  </div>
                </section>  
@endsection


@section('footjs')

@endsection












































