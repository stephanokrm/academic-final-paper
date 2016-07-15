@extends('app')

@section('title')
Usuário
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('users.show') !!}
@endsection

@section('content')
<div class="row center first-row">;
    <div class="col s12 m4 offset-m4 l4 offset-l4">
        <i class="material-icons large">photo</i> 
    </div>
</div>
<div class="row calendars-list">
    <div class="col s12 m4 offset-m4 l4 offset-l4">
        <ul class="collection">
            <li class="collection-item"><i class="material-icons left small">portrait</i> {{ $user->name }}</li>
            <li class="collection-item"><i class="material-icons left small">event</i> {{ $user->getBirthDate() }} - {{ $user->age() }} anos</li>
            <li class="collection-item"><i class="material-icons left small">security</i> {{ $user->registration }}</li>
            <li class="collection-item"><i class="material-icons left small">mail</i> {{ $user->email }}</li>
            <li class="collection-item"><i class="fa fa-google fa-2x" aria-hidden="true"></i> {{ $user->emailGoogle->email }}</li>
        </ul>
    </div>
</div>
<div class="fixed-action-btn horizontal">
    <a class="btn-floating btn-large red waves-effect waves-light" href="#!">
        <i class="large material-icons">mode_edit</i>
    </a>
</div>
@endsection