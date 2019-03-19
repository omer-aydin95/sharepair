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
                      <h2>Login</h2>
                    </header>
                    <form action="" method="post" id="idloginform">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="6u$ 12u$(xsmall)">
                          <input type="text" title="Enter your official school email." name="email" id="idemail" placeholder="School Email" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="password" title="Enter your password." name="passwrd" id="idpasswrd" placeholder="Password" />
                        </div>
                        <div class="6u$ 12u$(xsmall)" style="text-align: center;">
                          <ul class="actions">
                            <li><input type="submit" value="Login" class="special" /></li>
                          </ul>
                          <a href="reset">Forgot my password</a> / <a href="register">Register</a>
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












































