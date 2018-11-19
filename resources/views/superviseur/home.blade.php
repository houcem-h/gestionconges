@extends('layouts.appsuperv')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id='calendar'></div>            
        </div>
    </div>
</div>

<!--Canlendrier  -->
<link href='{{ asset('css/fullcalendar.min.css') }}' rel='stylesheet' />
<link href='{{ asset('css/fullcalendar.print.css') }}' rel='stylesheet' media='print' />
<script src='{{ asset('js/moment.min.js') }}'></script>
<script src='{{ asset('js/fullcalendar.min.js') }}'></script>
<script src='{{ asset('js/locale-all.js') }}'></script>
<script>
    $(function() {
    
        $('#calendar').fullCalendar({
        locale: 'fr',
        themeSystem: 'bootstrap4',
        header: {                
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        weekNumbers: true,
        eventLimit: true, // allow "more" link when too many events
        events: 'https://fullcalendar.io/demo-events.json'
        });
    
    });    
</script>
@endsection
