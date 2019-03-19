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
                      <h2>Send Message</h2>
                    </header>
                    <p>To: <?php echo '<a href="user?id=' . $user->GetID() . '">' . $user->GetName() . ' ' . $user->GetSurname() . '</a>'; ?> </p>
                    <form method="post" action="" id="idsendmform">

                      {{ csrf_field() }}
                      <?php echo '<input type="hidden" name="userid" value="' . $user->GetID() . '">' ?>

                      <div class="row uniform">
                        <div class="12u$">
                          <textarea name="message" id="idmessage" placeholder="Enter your message" rows="6"></textarea>
                        </div>
                        <div class="12u$" style="text-align: center;">
                          <ul class="actions">
                            <li><input type="submit" value="Send Message" class="special" /></li>
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
        $('#idsendmform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status);
          }
        });
      }
    );

  </script>

@endsection





















































