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
                      <h2>Create Announcement</h2>
                    </header>
                    <form action="" method="post" id="idcreateannoform">

                      {{ csrf_field() }}

                      <div class="row uniform">
                        <div class="12u$">
                          <textarea name="topic" title="Enter announcement study topic that you need get help." id="idtopic" placeholder="Enter study topic" rows="6"></textarea>
                        </div>
                        <div class="12u$">
                          <div class="select-wrapper">
                            <select name="sdate" id="idsdate">
                              <option>Select a study date</option>
                              <option>{{$curr_dates->date1}}</option>
                              <option>{{$curr_dates->date2}}</option>
                              <option>{{$curr_dates->date3}}</option>
                              <option>{{$curr_dates->date4}}</option>
                              <option>{{$curr_dates->date5}}</option>
                              <option>{{$curr_dates->date6}}</option>
                              <option>{{$curr_dates->date7}}</option>
                            </select>
                          </div>
                        </div>
                        <div class="12u$">
                          <div class="select-wrapper">
                            <select name="shour" id="idshour">
                              <option>Select a study hour</option>
                              <option>09:30 - 10:30</option>
                              <option>10:30 - 11:30</option>
                              <option>11:30 - 12:30</option>
                              <option>12:30 - 13:30</option>
                              <option>13:30 - 14:30</option>
                              <option>14:30 - 15:30</option>
                              <option>15:30 - 16:30</option>
                              <option>16:30 - 17:30</option>
                              <option>17:30 - 18:30</option>
                              <option>After 18:30</option>
                            </select>
                          </div>
                        </div>
                        <div class="12u$">
                          <div class="select-wrapper">
                            <select name="splace" id="idsplace">
                              <option value="-1">Select a study place</option>
                              
                              <?php

                                for($i = 0; $i < count($places); $i++)
                                  echo '<option value="' . $places[$i]->GetID() . '">' . $places[$i]->GetName() . ', ' . $places[$i]->GetDepartment() . ', ' . $places[$i]->GetFloor() . ', ' . $places[$i]->GetMaxCapacity() . '</option>';

                              ?>

                            </select>
                          </div>
                        </div>
                        <div class="12u$" style="text-align: center;">
                          <ul class="actions">
                            <li><input type="submit" value="Create" class="special" /></li>
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
        $('#idcreateannoform').ajaxForm({
          success:function(response)
          {
            swal(response.title, response.content, response.status);
          }
        });
      }
    );

  </script>

@endsection












































