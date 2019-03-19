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
                      <span class="image main" style="margin-left: 0; width: 192px; min-width: 192px; height: 192px; min-height: 192px;"><?php echo '<img src="' . Session::get('user')->GetPhoto() . '">' ?></span>
                      <h2>{{Session::get('user')->GetName()}} {{Session::get('user')->GetSurname()}}</h2>
                    </header>
                    <ul class="icons" style="font-weight: bold;">
                      <table>
                        <tr>
                          <td class="icon fa-envelope" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetSchoolEmail()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-graduation-cap" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetGrade()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-building" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetDepartment()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-book" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetAbout()}}</td>
                        </tr>
                        <tr>
                          <?php
                            if(Session::get('user')->GetWillTeach() == 1)
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
                    <ul class="actions">
                      <li><a href="settings" class="button default">Change Profile Settings</a></li>
                    </ul>
                    <hr class="major" style="background-color: #f56a6a; height: 3px;" />
                    <h3>Free Timetable</h3>
                    <form action="" method="post" id="idtableform">

                      {{ csrf_field() }}

                      <div class="table-wrapper">
                        <table>
                          <thead>
                            <tr>
                              <th style="text-align: center;">Hours</th>
                              <th style="text-align: center;">{{Session::get('table')['date1']}} Monday</th>
                              <th style="text-align: center;">{{Session::get('table')['date2']}} Tuesday</th>
                              <th style="text-align: center;">{{Session::get('table')['date3']}} Wednesday</th>
                              <th style="text-align: center;">{{Session::get('table')['date4']}} Thursday</th>
                              <th style="text-align: center;">{{Session::get('table')['date5']}} Friday</th>
                              <th style="text-align: center;">{{Session::get('table')['date6']}} Saturday</th>
                              <th style="text-align: center;">{{Session::get('table')['date7']}} Sunday</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="font-weight: bold;">
                                09:30 - 10:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|09:30-10:30|free" id="idpth1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|09:30-10:30|free" id="idpth1" name="check_list[]">';

                                  ?>
                                  <label for="idpth1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|09:30-10:30|free" id="idsah1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|09:30-10:30|free" id="idsah1" name="check_list[]">';

                                  ?>
                                  <label for="idsah1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|09:30-10:30|free" id="idcrh1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|09:30-10:30|free" id="idcrh1" name="check_list[]">';

                                  ?>
                                  <label for="idcrh1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|09:30-10:30|free" id="idprh1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|09:30-10:30|free" id="idprh1" name="check_list[]">';

                                  ?>
                                  <label for="idprh1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|09:30-10:30|free" id="idcuh1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|09:30-10:30|free" id="idcuh1" name="check_list[]">';

                                  ?>
                                  <label for="idcuh1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|09:30-10:30|free" id="idcmh1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|09:30-10:30|free" id="idcmh1" name="check_list[]">';

                                  ?>
                                  <label for="idcmh1"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['09:30-10:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|09:30-10:30|free" id="idpzh1" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|09:30-10:30|free" id="idpzh1" name="check_list[]">';

                                  ?>
                                  <label for="idpzh1"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                10:30 - 11:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|10:30-11:30|free" id="idpth2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|10:30-11:30|free" id="idpth2" name="check_list[]">';

                                  ?>
                                  <label for="idpth2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|10:30-11:30|free" id="idsah2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|10:30-11:30|free" id="idsah2" name="check_list[]">';

                                  ?>
                                  <label for="idsah2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|10:30-11:30|free" id="idcrh2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|10:30-11:30|free" id="idcrh2" name="check_list[]">';

                                  ?>
                                  <label for="idcrh2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|10:30-11:30|free" id="idprh2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|10:30-11:30|free" id="idprh2" name="check_list[]">';

                                  ?>
                                  <label for="idprh2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|10:30-11:30|free" id="idcuh2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|10:30-11:30|free" id="idcuh2" name="check_list[]">';

                                  ?>
                                  <label for="idcuh2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|10:30-11:30|free" id="idcmh2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|10:30-11:30|free" id="idcmh2" name="check_list[]">';

                                  ?>
                                  <label for="idcmh2"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['10:30-11:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|10:30-11:30|free" id="idpzh2" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|10:30-11:30|free" id="idpzh2" name="check_list[]">';

                                  ?>
                                  <label for="idpzh2"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                11:30 - 12:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|11:30-12:30|free" id="idpth3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|11:30-12:30|free" id="idpth3" name="check_list[]">';

                                  ?>
                                  <label for="idpth3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|11:30-12:30|free" id="idsah3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|11:30-12:30|free" id="idsah3" name="check_list[]">';

                                  ?>
                                  <label for="idsah3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|11:30-12:30|free" id="idcrh3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|11:30-12:30|free" id="idcrh3" name="check_list[]">';

                                  ?>
                                  <label for="idcrh3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|11:30-12:30|free" id="idprh3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|11:30-12:30|free" id="idprh3" name="check_list[]">';

                                  ?>
                                  <label for="idprh3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|11:30-12:30|free" id="idcuh3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|11:30-12:30|free" id="idcuh3" name="check_list[]">';

                                  ?>
                                  <label for="idcuh3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|11:30-12:30|free" id="idcmh3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|11:30-12:30|free" id="idcmh3" name="check_list[]">';

                                  ?>
                                  <label for="idcmh3"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['11:30-12:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|11:30-12:30|free" id="idpzh3" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|11:30-12:30|free" id="idpzh3" name="check_list[]">';

                                  ?>
                                  <label for="idpzh3"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                12:30 - 13:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|12:30-13:30|free" id="idpth4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|12:30-13:30|free" id="idpth4" name="check_list[]">';

                                  ?>
                                  <label for="idpth4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|12:30-13:30|free" id="idsah4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|12:30-13:30|free" id="idsah4" name="check_list[]">';

                                  ?>
                                  <label for="idsah4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|12:30-13:30|free" id="idcrh4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|12:30-13:30|free" id="idcrh4" name="check_list[]">';

                                  ?>
                                  <label for="idcrh4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|12:30-13:30|free" id="idprh4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|12:30-13:30|free" id="idprh4" name="check_list[]">';

                                  ?>
                                  <label for="idprh4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|12:30-13:30|free" id="idcuh4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|12:30-13:30|free" id="idcuh4" name="check_list[]">';

                                  ?>
                                  <label for="idcuh4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|12:30-13:30|free" id="idcmh4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|12:30-13:30|free" id="idcmh4" name="check_list[]">';

                                  ?>
                                  <label for="idcmh4"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['12:30-13:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|12:30-13:30|free" id="idpzh4" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|12:30-13:30|free" id="idpzh4" name="check_list[]">';

                                  ?>
                                  <label for="idpzh4"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                13:30 - 14:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|13:30-14:30|free" id="idpth5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|13:30-14:30|free" id="idpth5" name="check_list[]">';

                                  ?>
                                  <label for="idpth5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|13:30-14:30|free" id="idsah5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|13:30-14:30|free" id="idsah5" name="check_list[]">';

                                  ?>
                                  <label for="idsah5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|13:30-14:30|free" id="idcrh5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|13:30-14:30|free" id="idcrh5" name="check_list[]">';

                                  ?>
                                  <label for="idcrh5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|13:30-14:30|free" id="idprh5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|13:30-14:30|free" id="idprh5" name="check_list[]">';

                                  ?>
                                  <label for="idprh5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|13:30-14:30|free" id="idcuh5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|13:30-14:30|free" id="idcuh5" name="check_list[]">';

                                  ?>
                                  <label for="idcuh5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|13:30-14:30|free" id="idcmh5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|13:30-14:30|free" id="idcmh5" name="check_list[]">';

                                  ?>
                                  <label for="idcmh5"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['13:30-14:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|13:30-14:30|free" id="idpzh5" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|13:30-14:30|free" id="idpzh5" name="check_list[]">';

                                  ?>
                                  <label for="idpzh5"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                14:30 - 15:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|14:30-15:30|free" id="idpth6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|14:30-15:30|free" id="idpth6" name="check_list[]">';

                                  ?>
                                  <label for="idpth6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|14:30-15:30|free" id="idsah6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|14:30-15:30|free" id="idsah6" name="check_list[]">';

                                  ?>
                                  <label for="idsah6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|14:30-15:30|free" id="idcrh6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|14:30-15:30|free" id="idcrh6" name="check_list[]">';

                                  ?>
                                  <label for="idcrh6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|14:30-15:30|free" id="idprh6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|14:30-15:30|free" id="idprh6" name="check_list[]">';

                                  ?>
                                  <label for="idprh6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|14:30-15:30|free" id="idcuh6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|14:30-15:30|free" id="idcuh6" name="check_list[]">';

                                  ?>
                                  <label for="idcuh6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|14:30-15:30|free" id="idcmh6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|14:30-15:30|free" id="idcmh6" name="check_list[]">';

                                  ?>
                                  <label for="idcmh6"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['14:30-15:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|14:30-15:30|free" id="idpzh6" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|14:30-15:30|free" id="idpzh6" name="check_list[]">';

                                  ?>
                                  <label for="idpzh6"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                15:30 - 16:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|15:30-16:30|free" id="idpth7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|15:30-16:30|free" id="idpth7" name="check_list[]">';

                                  ?>
                                  <label for="idpth7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|15:30-16:30|free" id="idsah7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|15:30-16:30|free" id="idsah7" name="check_list[]">';

                                  ?>
                                  <label for="idsah7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|15:30-16:30|free" id="idcrh7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|15:30-16:30|free" id="idcrh7" name="check_list[]">';

                                  ?>
                                  <label for="idcrh7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|15:30-16:30|free" id="idprh7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|15:30-16:30|free" id="idprh7" name="check_list[]">';

                                  ?>
                                  <label for="idprh7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|15:30-16:30|free" id="idcuh7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|15:30-16:30|free" id="idcuh7" name="check_list[]">';

                                  ?>
                                  <label for="idcuh7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|15:30-16:30|free" id="idcmh7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|15:30-16:30|free" id="idcmh7" name="check_list[]">';

                                  ?>
                                  <label for="idcmh7"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['15:30-16:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|15:30-16:30|free" id="idpzh7" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|15:30-16:30|free" id="idpzh7" name="check_list[]">';

                                  ?>
                                  <label for="idpzh7"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                16:30 - 17:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|16:30-17:30|free" id="idpth8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|16:30-17:30|free" id="idpth8" name="check_list[]">';

                                  ?>
                                  <label for="idpth8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|16:30-17:30|free" id="idsah8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|16:30-17:30|free" id="idsah8" name="check_list[]">';

                                  ?>
                                  <label for="idsah8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|16:30-17:30|free" id="idcrh8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|16:30-17:30|free" id="idcrh8" name="check_list[]">';

                                  ?>
                                  <label for="idcrh8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|16:30-17:30|free" id="idprh8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|16:30-17:30|free" id="idprh8" name="check_list[]">';

                                  ?>
                                  <label for="idprh8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|16:30-17:30|free" id="idcuh8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|16:30-17:30|free" id="idcuh8" name="check_list[]">';

                                  ?>
                                  <label for="idcuh8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|16:30-17:30|free" id="idcmh8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|16:30-17:30|free" id="idcmh8" name="check_list[]">';

                                  ?>
                                  <label for="idcmh8"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['16:30-17:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|16:30-17:30|free" id="idpzh8" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|16:30-17:30|free" id="idpzh8" name="check_list[]">';

                                  ?>
                                  <label for="idpzh8"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                17:30 - 18:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|17:30-18:30|free" id="idpth9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|17:30-18:30|free" id="idpth9" name="check_list[]">';

                                  ?>
                                  <label for="idpth9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|17:30-18:30|free" id="idsah9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|17:30-18:30|free" id="idsah9" name="check_list[]">';

                                  ?>
                                  <label for="idsah9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|17:30-18:30|free" id="idcrh9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|17:30-18:30|free" id="idcrh9" name="check_list[]">';

                                  ?>
                                  <label for="idcrh9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|17:30-18:30|free" id="idprh9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|17:30-18:30|free" id="idprh9" name="check_list[]">';

                                  ?>
                                  <label for="idprh9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|17:30-18:30|free" id="idcuh9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|17:30-18:30|free" id="idcuh9" name="check_list[]">';

                                  ?>
                                  <label for="idcuh9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|17:30-18:30|free" id="idcmh9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|17:30-18:30|free" id="idcmh9" name="check_list[]">';

                                  ?>
                                  <label for="idcmh9"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['17:30-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|17:30-18:30|free" id="idpzh9" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|17:30-18:30|free" id="idpzh9" name="check_list[]">';

                                  ?>
                                  <label for="idpzh9"></label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td style="font-weight: bold;">
                                After 18:30
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours1']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours1|after-18:30|free" id="idpth10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours1|after-18:30|free" id="idpth10" name="check_list[]">';

                                  ?>
                                  <label for="idpth10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours2']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours2|after-18:30|free" id="idsah10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours2|after-18:30|free" id="idsah10" name="check_list[]">';

                                  ?>
                                  <label for="idsah10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours3']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours3|after-18:30|free" id="idcrh10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours3|after-18:30|free" id="idcrh10" name="check_list[]">';

                                  ?>
                                  <label for="idcrh10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours4']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours4|after-18:30|free" id="idprh10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours4|after-18:30|free" id="idprh10" name="check_list[]">';

                                  ?>
                                  <label for="idprh10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours5']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours5|after-18:30|free" id="idcuh10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours5|after-18:30|free" id="idcuh10" name="check_list[]">';

                                  ?>
                                  <label for="idcuh10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours6']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours6|after-18:30|free" id="idcmh10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours6|after-18:30|free" id="idcmh10" name="check_list[]">';

                                  ?>
                                  <label for="idcmh10"></label>
                                </div>
                              </td>
                              <td align="center">
                                <div class="6u$ 12u$(xsmall)">
                                  <?php

                                    if(Session::get('table')['hours7']['after-18:30']['free'] == 1)
                                      echo '<input type="checkbox" value="hours7|after-18:30|free" id="idpzh10" name="check_list[]" checked>';
                                    else
                                      echo '<input type="checkbox" value="hours7|after-18:30|free" id="idpzh10" name="check_list[]">';

                                  ?>
                                  <label for="idpzh10"></label>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <br>
                      <div class="6u$ 12u$(xsmall)">
                        <ul class="actions">
                          <li><input type="submit" name="submitbutton" value="Save Table" class="special" /></li>
                        </ul>
                      </div>
                    </form>
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
        $('#idtableform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status)
          }
        });
      }
    );

  </script>

@endsection












































