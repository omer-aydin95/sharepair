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
                      <h2>Renew Password</h2>
                    </header>
                    <form method="post" action="" id="idrenewform">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="6u$ 12u$(xsmall)">
                          <input type="password" name="newpass" title="Create a new password." id="idnewpass" placeholder="New Password" />
                        </div>
                        <div class="6u$ 12u$(xsmall)">
                          <input type="password" name="connewpass" title="Confirm your created new password." id="idconnewpass" placeholder="Confirm New Password" />
                        </div>
                        <div class="6u$ 12u$(xsmall)" style="text-align: center;">
                          <ul class="actions">
                            <li><input type="submit" value="Renew" class="special" /></li>
                          </ul>
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
        $('#idrenewform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status)
          }
        });
      }
    );

  </script>

@endsection












































