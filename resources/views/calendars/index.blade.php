@extends('app')

@section('title')
Calendários
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('calendars') !!}
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/css/calendars/index-mobile.css') }}">
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2" id="no-side-margin">
    <div class="row first-row calendars-list">
        @if(empty($calendars))
        <div class="center">
            <i class="material-icons extra-large grey-text text-lighten-2">event_note</i>
            <h4 class="grey-text text-lighten-2">Os calendários criados no Academic aparecem aqui.</h4>
        </div>
        @else
        {!! Form::open([ 'method'  => 'post', 'route' => 'calendars.destroy', 'class' => 'form-delete']) !!}
        <ul class="collection">
            @foreach ($calendars as $calendar)
            <li class="collection-item">
                <div class="row">
                    <div class="col s2 m2 l1" id="no-side-margin">
                        <input type="checkbox" name="calendars[]" value="{{ $calendar->getId() }}" class="filled-in delete-calendar" id="delete_{{ $calendar->getId() }}" />
                        <label for="delete_{{ $calendar->getId() }}"></label>
                    </div>
                    <div class="col s4 m5 l6 truncate calendar-summary" id="no-side-margin">
                        {{ $calendar->getSummary() }}
                    </div>
                    <div class="col s6 m5 l5" id="no-side-margin">
                        <a href="#">
                            <i class="material-icons right waves-effect waves-blue">more_vert</i>
                        </a>
                        <a href="{{ route('events.index', Crypt::encrypt($calendar->getId())) }}">
                            <i class="material-icons right waves-effect waves-blue">arrow_forward</i>
                        </a>
                        <a href="{{ route('calendars.edit', Crypt::encrypt($calendar->getId())) }}">
                            <i class="material-icons right waves-effect waves-blue">mode_edit</i>
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        {!! Form::close() !!} 
        @endif
    </div>
</div>
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('calendars.create') }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/calendars/index.js') }}"></script>
@endsection
