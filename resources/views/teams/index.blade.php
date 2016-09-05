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
                <th width="18%">Turma</th>
                <th width="18%">Curso</th>
                <th width="18%">Ano</th>
                <th width="41%">Disciplina</th>
                <th width="5%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
            <tr>
                <td>{{ $team->year }}º Ano</td>
                <td>{{ $team->abbreviation }}</td>
                <td>{{ $team->school_year }}</td>
                <td>{{ $team->discipline }}</td>
                <td>
                    <a href="{{ route('teams.show', $team->id) }}">
                        <i class="material-icons waves-effect waves-blue waves-circle">arrow_forward</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
