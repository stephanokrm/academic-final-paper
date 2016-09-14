@extends('app', ['showNav' => 'true'])

@section('title')
Login
@endsection

@section('content')
<div class="col s12 m4 offset-m4 l4 offset-l4">
    <div class="card white">
        {!! Form::open(['method' => 'POST', 'route' => 'auth.ldap', 'id' => 'login_form']) !!}
        <div class="card-content white-text">
            
            <div class="row center">
                <img class="academic-logo-login" src="{{ asset('/images/academic-logo.svg') }}">
            </div>
            <div class="row center">
                <h4 class="black-text">Academic</h4>
            </div>
            
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <input type="text" class="validate black-text" id="usernanme" name="username"/>
                    <label for="username">Matrícula</label>
                </div>
                @if($errors->has('username'))
                <span class="error">{{ $errors->first('username') }}</span>
                @endif
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    {!! Form::password('password', ['class' => 'validate black-text', 'id' => 'password']) !!}
                    {!! Form::label('password', 'Senha') !!}
                </div>
                @if($errors->has('password'))
                <span class="help-block">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="card-action center">
            <button type="submit" class="btn light-blue" id="submit_login" disabled=""><i class="material-icons left">arrow_forward</i>Entrar</button> 
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/js/auth/login.js') }}"></script>
@endsection
