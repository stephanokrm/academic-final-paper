@extends('app')

@section('title')
Eventos
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/fullcalendar/fullcalendar.min.css') }}" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{ asset('/css/events/index.css') }}"/>
@endsection

@section('content')
<span id="calendar_id" data-id="{{ Input::route('id') }}"></span>
<div id="event" class="modal">
    <div class="modal-header">
        <div class="row">
            <div class="col s10 m10 l10 event-title">
                <div class="event-title-text truncate"></div>
            </div>
            <div class="col s2 m2 l2 event-edit">
                <a class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">mode_edit</i></a>
            </div>
        </div>  
    </div>
    <div class="modal-content"> 
        <div class="row row-content">
            <div class="col s2 m1 l1">
                <i class="material-icons small grey-text text-darken-1">alarm</i>
            </div>
            <div class="col s10 m11 l11 event-date"></div>
        </div> 
        <div class="row">
            <div class="col s2 m1 l1">
                <i class="material-icons small grey-text text-darken-1">description</i>
            </div>
            <div class="col s10 m11 l11 description"></div>
        </div>
    </div>
    <!--    <div class="modal-footer"> 
            <a href="#!" class="modal-action modal-close waves-effect btn-flat close-event-btn">Fechar</a>
            <form method="POST" action="" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <input name="calendar_id" type="hidden" value="{{ $calendar }}">
                <button type="submit" class="btn-flat waves-effect">Excluir</button>
            </form>
        </div> -->
</div>
<div class="row" id="calendar-header">
    <div class="col s12 m4 l4 left" id="left_section_header">
        <div class="row">
            <div class="col s1 m1 l1">
                <i class="material-icons white-text">today</i>
            </div>
            <div class="col s11 m11 l11">
                <h5 class="white-text">Calendário</h5>
            </div>
        </div>
    </div>
    <div class="col s12 m4 l4" id="middle_section_header">
        <div class="row">
            <div class="col s1 m1 l1 offset-s1 offset-m3 offset-l3">
                <i id="left_arrow" class="material-icons white-text waves-effect waves-circle waves-light left">keyboard_arrow_left</i>
            </div>
            <div class="col s6 m5 l5 offset-s1 center">
                <h5 class="white-text" id="calendar_date"></h5>
            </div>
            <div class="col s1 m1 l1 offset-s1">
                <i id="right_arrow" class="material-icons white-text waves-effect waves-circle waves-light left">keyboard_arrow_right</i>
            </div>
        </div>
    </div>
    <div class="col s12 m4 l4 right" id="right_section_header">
        <div class="row">
            <div class="col s2 m1 l1 offset-s4 offset-m7 offset-l7">
                <i id="today" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Hoje">today</i>
            </div>
            <div class="col s2 m1 l1">
                <i id="day_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Dia">view_day</i>
            </div>
            <div class="col s2 m1 l1">
                <i id="week_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Semana">view_column</i>
            </div>
            <div class="col s2 m1 l1">
                <i id="month_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light" data-position="bottom" data-delay="50" data-tooltip="Mês">view_module</i>
            </div>
        </div>
    </div>
</div>
<div class="row first-row-events events-list">
    <div class="col s12 m12 l12" id="events-calendar">
        <div class="row">
            <div id="calendar"></div>
        </div>
    </div>
    <div class="col s12 m3 l2 hide" id="events-colletion"></div>
</div> 
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('events.create', Input::route('id')) }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/laroute.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lib/moment.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/fullcalendar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lang-all.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/gcal.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/events/index.js') }}"></script>
@endsection
