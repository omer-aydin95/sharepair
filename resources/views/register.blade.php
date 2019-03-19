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
                      <h2>Register</h2>
                    </header>
                    <form action="" method="post" name="regform" id="idregform" enctype="multipart/form-data">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="6u$ 12u$(xsmall)">
                          <input type="text" title="Enter your firstname." name="name" id="idname" maxlength="50" placeholder="Name" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="text" title="Enter your lastname." name="surname" id="idsurname" maxlength="50" placeholder="Surname" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="text" title="Enter your official email." name="email" id="idemail" maxlength="100" placeholder="School Email" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="password" title="Create a new password." name="passwrd" id="idpasswrd" maxlength="10" placeholder="Password" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="password" title="Confirm your created password." name="conpasswrd" id="idconpasswrd" maxlength="10" placeholder="Confirm Password" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <div class="select-wrapper">
                            <select name="gradecategory" id="idgradecategory">
                              <option>Select your grade</option>
                              <option>Preparation</option>
                              <option>1. Grade</option>
                              <option>2. Grade</option>
                              <option>3. Grade</option>
                              <option>4. Grade</option>
                              <option>Graduate / Master</option>
                              <option>PhD / Doctorate</option>
                            </select>
                          </div>
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <div class="select-wrapper">
                            <select name="depcategory" id="iddepcategory">
                              <option>Select your department</option>
                              <?php

                                for($i = 0; $i < count($deps); $i++)
                                {
                                  echo '<option>' . $deps[$i]->GetName() . '</option>';
                                }

                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <label for="idpicfile" class="button fit">Upload profile photo</label>
                          <input type="file" accept="image/jpeg,image/png" id="idpicfile" name="picfile" style="visibility: hidden;">
                        </div>
                        <div class="6u$ 12u$(xsmall)" style="text-align: center;">
                          <ul class="actions">
                            <li><input type="submit" value="Submit" class="special" /></li>
                          </ul>
                          <a href="login">Do you have an account? Fine login</a>
                        </div>
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
        $('#idregform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status)
          }
        });
      }
    );

  </script>

@endsection












































