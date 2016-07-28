@extends('app')

@section('title')
Atividades
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('activities.index') !!}
@endsection

@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('/css/calendars/index-mobile.css') }}">
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2" id="no-side-margin">
    <div class="row first-row calendars-list">
        @if($activities->count() == 0)
        <div class="center">
            <i class="material-icons extra-large grey-text text-lighten-2">import_contacts</i>
            <h4 class="grey-text text-lighten-2">As atividades criados pelo professor aparecem aqui.</h4>
        </div>
        @else
        @if(Session::get('user')->hasRole(2))
        {!! Form::open(['method' => 'post', 'route' => 'activities.destroy', 'class' => 'form-delete']) !!}
        @endif
        <ul class="collection">
            @foreach($activities as $activity)
            <li class="collection-item">
                <div class="row">
                    @if(Session::get('user')->hasRole(2))
                    <div class="col s2 m2 l1" id="no-side-margin">
                        <input type="checkbox" name="activities[]" value="{{ $activity->getId() }}" class="filled-in delete-activity" id="delete_{{ $activity->getId() }}" />
                        <label for="delete_{{ $activity->getId() }}"></label>
                    </div>
                    @endif
                    <div class="col s4 m5 l6 truncate calendar-summary" id="no-side-margin">
                        {{ $activity->getTitle() }}
                    </div>
                    <div class="col s6 m5 l5" id="no-side-margin">
                        <a href="#">
                            <i class="material-icons right waves-effect waves-blue">more_vert</i>
                        </a>
                        <a href="{{ route('activities.show', $activity->getId()) }}">
                            <i class="material-icons right waves-effect waves-blue">arrow_forward</i>
                        </a>
                        <a href="{{ route('activities.edit', $activity->getId()) }}">
                            <i class="material-icons right waves-effect waves-blue">mode_edit</i>
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @if(Session::get('user')->hasRole(2))
        {!! Form::close() !!}
        @endif
        @endif
    </div>
</div>
@if(Session::get('user')->hasRole(2))
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="{{ route('activities.create', Input::route('id')) }}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endif
@endsection



@section('js')
<script src="{{ asset('/js/activities/index.js') }}"></script>
@endsection
