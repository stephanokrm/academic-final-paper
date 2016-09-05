@extends('app')

@section('title')
Calendários
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/fullcalendar/fullcalendar.min.css') }}" media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="{{ asset('/css/calendars/index.css') }}"/>
@endsection

@section('content')
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
</div>
<div class="row" id="calendar-panel">
    <div class="col s12 m4 l4">
        <a class="waves-effect waves-light btn light-blue" href="{{ route('calendars.create') }}">Adicionar Calendário</a>
    </div>
    <div class="col s12 m4 l4">
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
    <div class="col s12 m4 l4">
        <div class="row">
            <div class="col s2 m2 l1 offset-s4 offset-m4 offset-l7">
                <i id="today" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Hoje">today</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="day_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Dia">view_day</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="week_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light"  data-position="bottom" data-delay="50" data-tooltip="Semana">view_column</i>
            </div>
            <div class="col s2 m2 l1">
                <i id="month_view" class="material-icons white-text tooltipped waves-effect waves-circle waves-light" data-position="bottom" data-delay="50" data-tooltip="Mês">view_module</i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 m4 l2">
        <ul class="collapsible calendar-collection" data-collapsible="accordion">
            <li>
                <div class="collapsible-header active" id="calendars-collapsible-header">Calendários<i class="material-icons right" id="keyboard_arrow_up">keyboard_arrow_up</i><i class="material-icons right hide" id="keyboard_arrow_down">keyboard_arrow_down</i></div>
                <div class="collapsible-body">
                    <ul class="collection calendar-collection">
                        @foreach($calendars as $calendar)
                        <li class="collection-item">
                            <div>{{ $calendar->getSummary() }}
                                <a href="#!" class="secondary-content">
                                    <input type="checkbox" class="filled-in" data-id="{{ $calendar->getId() }}" id="calendar_{{ $calendar->getId() }}" checked="checked" />
                                    <label for="calendar_{{ $calendar->getId() }}"></label>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="col s12 m8 l10">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/laroute.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lib/moment.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/fullcalendar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/lang-all.js') }}"></script>
<script type='text/javascript' src="{{ asset('/fullcalendar/gcal.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/calendars/index.js') }}"></script>
@endsection
