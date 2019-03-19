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
                      <h2>Profile Settings</h2>
                    </header>
                    <form action="" method="post" id="idsettingform">

                      {{ csrf_field() }}

                    <ul class="icons" style="font-weight: bold;">
                      <table>
                        <tr>
                          <td class="icon fa-user" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetName()}} {{Session::get('user')->GetSurname()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-envelope" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>{{Session::get('user')->GetSchoolEmail()}}</td>
                        </tr>
                        <tr>
                          <td class="icon fa-lock" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>
                            <div class="12u$">
                              <input type="password" name="curpasswrd" id="idcurpasswrd" placeholder="Current Password" /><br>
                              <input type="password" name="newpasswrd" id="idnewpasswrd" placeholder="New Password" /><br>
                              <input type="password" name="repasswrd" id="idrepasswrd" placeholder="Repeat Password" />
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="icon fa-graduation-cap" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>
                            <div class="12u$">
                              <div class="select-wrapper">
                                <select name="gradecategory" id="idgradecategory">
                                  <option>Select your grade</option>

                                  <option <?php if(Session::get('user')->GetGrade() == 'Preparation') echo 'selected=""'; ?> >Preparation</option>

                                  <option <?php if(Session::get('user')->GetGrade() == '1. Grade') echo 'selected=""'; ?> >1. Grade</option>

                                  <option <?php if(Session::get('user')->GetGrade() == '2. Grade') echo 'selected=""'; ?> >2. Grade</option>

                                  <option <?php if(Session::get('user')->GetGrade() == '3. Grade') echo 'selected=""'; ?> >3. Grade</option>

                                  <option <?php if(Session::get('user')->GetGrade() == '4. Grade') echo 'selected=""'; ?> >4. Grade</option>

                                  <option <?php if(Session::get('user')->GetGrade() == 'Graduate / Master') echo 'selected=""'; ?> >Graduate / Master</option>

                                  <option <?php if(Session::get('user')->GetGrade() == 'PhD / Doctorate') echo 'selected=""'; ?> >PhD / Doctorate</option>
                                </select>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="icon fa-building" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>
                            <div class="12u$">
                              <div class="select-wrapper">
                                <select name="depcategory" id="iddepcategory">
                                  <option>Select your department</option>
                                  <?php

                                    for($i = 0; $i < count($deps); $i++)
                                    {
                                      if(Session::get('user')->GetDepartment() == $deps[$i]->GetName())
                                        echo '<option selected="">' . $deps[$i]->GetName() . '</option>';
                                      else
                                        echo '<option>' . $deps[$i]->GetName() . '</option>';
                                    }

                                  ?>
                                </select>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="icon fa-book" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>
                            <div class="12u$">
                              <textarea name="about" id="idabout" placeholder="Enter about yourself" rows="6">{{Session::get('user')->GetAbout()}}</textarea>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <?php

                            if(Session::get('user')->GetWillTeach() == 0)
                              echo '<td class="icon fa-times" style="width: 32px; text-align: center; font-size: 18px;"></td>';
                            else
                              echo '<td class="icon fa-check" style="width: 32px; text-align: center; font-size: 18px;"></td>';

                          ?>
                          <td>
                            <div class="12u$">
                              <div class="select-wrapper">
                                <select name="teach" id="idteach">
                                  <option <?php if(Session::get('user')->GetWillTeach() == 0) echo 'selected=""'; ?> >I will not teach some topics to other students</option>

                                  <option <?php if(Session::get('user')->GetWillTeach() == 1) echo 'selected=""'; ?> >I will teach some topics to other students</option>
                                </select>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="icon fa-image" style="width: 32px; text-align: center; font-size: 18px;"></td>
                          <td>
                            <div class="12u$(xsmall)">
                              <label for="idpicfile" class="button default">Upload profile photo</label>
                              <input type="file" accept="image/jpeg,image/png" id="idpicfile" name="picfile" style="visibility: hidden;">
                            </div>
                          </td>
                        </tr>
                      </table>
                    </ul>
                    <div class="6u$ 12u$(xsmall)">
                      <ul class="actions">
                        <li><input type="submit" value="Save Settings" class="special" /></li>
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
        $('#idsettingform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status)
          }
        });
      }
    );

  </script>

@endsection












































