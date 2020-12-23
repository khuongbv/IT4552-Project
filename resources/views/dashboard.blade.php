@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <style>

      #script-warning {
        display: none;
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        color: red;
      }

      #loading {
        display: none;
        position: absolute;
        top: 10px;
        right: 10px;
      }

      #calendar {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 10px;
      }

    </style>
    <div class="content">
        <div id='script-warning'>
          <code>ics/feed.ics</code> must be servable
        </div>

        <div id='loading'>loading...</div>
        <div id="calendar"></div>
    </div>
    
    
    <script>

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');

          var calendar = new FullCalendar.Calendar(calendarEl, {
            displayEventTime: false,
            initialDate: '2020-12-30',
            headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,listYear'
            },
            events: {
              url: 'ics/feed.ics',
              format: 'ics',
              failure: function() {
                document.getElementById('script-warning').style.display = 'block';
              }
            },
            loading: function(bool) {
              document.getElementById('loading').style.display =
                bool ? 'block' : 'none';
            }
          });

          calendar.render();
        });

    </script>
    
@endsection

