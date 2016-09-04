@extends('app', ['showNav' => 'true'])

@section('title')
Login
@endsection

@section('content')
<div class="col s12 m4 offset-m4 l4 offset-l4">
    <div class="card white">
        <div class="card-content white-text">
            <div class="row center">
                <img class="academic-logo-login" src="{{ asset('/images/academic-logo.svg') }}">
            </div>
            <div class="row center">
                <h4 class="black-text">Academic</h4>
            </div>
            {!! Form::open(['method' => 'POST', 'route' => 'auth.ldap']) !!}
            <div class="row">
                <label>Matrícula</label>
                {!! Form::text('username', null, ['class' => 'black-text']) !!}
                @if($errors->has('username'))
                <span class="help-block">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="row">
                <label>Senha</label>
                {!! Form::password('password', ['class' => 'black-text']) !!}
                @if($errors->has('password'))
                <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="card-action center">
            <button type="submit" class="btn light-blue"><i class="material-icons left">arrow_forward</i>Entrar</button> 
        </div>
    </div>
</div>
@endsection
