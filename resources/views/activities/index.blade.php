@extends('app')

@section('title')
Atividades
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2" id="no-side-margin">
<!--    <div class="row">
        <div class="col s4 m2 l2">
            <a class="waves-effect waves-light btn light-blue" href="{{ URL::previous() }}"><i class="material-icons left">arrow_back</i><span class="hide-on-med-and-down">voltar</span></a>
        </div>
        <div class="col s4 m2 l2">
            <a class="waves-effect waves-light btn white black-text"><i class="material-icons left black-text">mail</i><span class="hide-on-med-and-down">E-mail</span></a>
        </div>
        <div class="col s4 m2 l2">
            <a class="waves-effect waves-light btn white black-text"><i class="material-icons left black-text">file_download</i><span class="hide-on-med-and-down">baixar</span></a>
        </div>
    </div>-->
    <div class="row">
        <div class="col s12 m12 l12">
            @if(count($activities) == 0)
            <div class="center">
                <i class="material-icons extra-large grey-text text-lighten-2">import_contacts</i>
                <h4 class="grey-text text-lighten-2">As atividades criados pelo professor aparecem aqui.</h4>
            </div>
            @else
            @if(Session::get('user')->hasRole(2))
            {!! Form::open(['method' => 'post', 'route' => 'activities.destroy', 'class' => 'form-delete']) !!}
            @endif
            <table class="bordered highlight">
                <thead>
                    <tr>
                        @if(Session::get('user')->hasRole(2))
                        <th width="15%">
                            <div class="center">
                                {!! Form::checkbox('select_all', null, old('select_all'), ['class' => 'filled-in', 'id' => 'select_all']) !!}
                                <label for="select_all"></label>
                            </div>
                        </th>
                        @endif
                        <th width="35%">Atividade</th>
                        <th width="38%">Data</th>
                        <th width="12%">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                    <tr>
                        @if(Session::get('user')->hasRole(2))
                        <td>
                            <div class="center">
                                <input type="checkbox" name="activities[]" value="{{ $activity->getId() }}" class="filled-in delete-activity activity-item" id="delete_{{ $activity->getId() }}" />
                                <label for="delete_{{ $activity->getId() }}"></label>
                            </div>
                        </td>
                        @endif
                        <td>{{ $activity->getSummary() }}</td>
                        <td>{{ $activity->getDate() }}</td>
                        <td>
                            <a href="{{ route('activities.edit', $activity->getId()) }}">
                                <i class="material-icons waves-effect waves-blue">mode_edit</i>
                            </a>
                            <a href="{{ route('activities.show', $activity->getId()) }}">
                                <i class="material-icons waves-effect waves-blue">arrow_forward</i>
                            </a>
                            <a href="#">
                                <i class="material-icons waves-effect waves-blue">more_vert</i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if(Session::get('user')->hasRole(2))
            {!! Form::close() !!}
            @endif
            @endif
        </div>
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
