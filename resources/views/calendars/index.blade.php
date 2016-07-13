@extends('app')

@section('title')
Calendários
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('calendars') !!}
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    <div class="row first-row calendars-list">
        {!! Form::open([ 'method'  => 'post', 'route' => 'calendars.destroy', 'class' => 'form-delete']) !!}
         <ul class="collapsible popout" data-collapsible="accordion">
            @foreach ($calendars as $calendar)
            <li>
                <div class="collapsible-header">
                    <input type="checkbox" name="calendars[]" value="{{ $calendar->getId() }}" class="filled-in delete-calendar show-on-hove hide" id="delete_{{ $calendar->getId() }}" />
                    <label class="show-on-hove hide" for="delete_{{ $calendar->getId() }}"></label>
                    {{ $calendar->getSummary() }}
                    <a href="#">
                        <i class="material-icons right show-on-hove hide">more_vert</i>
                    </a>
                    <a href="#">
                        <i class="material-icons right show-on-hove hide">arrow_forward</i>
                    </a>
                    <a href="#">
                        <i class="material-icons right show-on-hover hide">mode_edit</i>
                    </a>
                </div>
                {{-- <a href="{{ route('events.index', Crypt::encrypt($calendar->getId())) }}" class="secondary-content">
                    <i class="material-icons no-margin-right">forward</i>
                </a>
                <a href="{{ route('calendars.edit', Crypt::encrypt($calendar->getId())) }}" class="secondary-content">
                   	<i class="material-icons">settings</i>
                </a>
                <a href="#!" class="secondary-content submit-calendars-delete">
                    <i class="material-icons">delete</i>
                </a>
                {!! Form::open([ 'method'  => 'delete', 'route' => [ 'calendars.destroy', Crypt::encrypt($calendar->getId()) ] ]) !!}
                {!! Form::close() !!} --}}
                <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>

            </li>
            @endforeach
        </ul>   
        {!! Form::close() !!} 
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
