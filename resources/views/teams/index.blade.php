@extends('app')

@section('title')
Turmas
@endsection

@section('content')
<div class="col s12 m8 offset-m2 l8 offset-l2">
    @if($teams->count() == 0)
    <div class="center">
        <i class="material-icons extra-large grey-text text-lighten-2">group</i>
        <h4 class="grey-text text-lighten-2">As turmas vinculadas ao professor aparecem aqui</h4>
    </div>
    @else
    <table class="bordered highlight list-table">
        <thead>
            <tr>
                <th width="25%">Turma</th>
                <th width="24%">Curso</th>
                <th width="24%">Ano</th>
                <th width="12%" colspan="3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
            <tr>
                <td>{{ $team->year }}º ano</td>
                <td>{{ $team->course->abbreviation }}</td>
                <td>{{ $team->school_year }}</td>
                <td>
                    <a href="#">
                        <i class="material-icons waves-effect waves-blue">mode_edit</i>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <i class="material-icons waves-effect waves-blue">arrow_forward</i>
                    </a>
                </td>
                <td>
                    <a href="#">
                        <i class="material-icons waves-effect waves-blue">more_vert</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
