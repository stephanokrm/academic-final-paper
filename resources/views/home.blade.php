@extends('app')

@section('title')
Início
@endsection

@section('breadcrumb')
{!! Breadcrumbs::render('home') !!}
@endsection

@section('content')
<div class="col s12 m12 l12">
    <div class="row center">
        <img class="academic-logo-home" src="{{ asset('/images/academic-logo.svg') }}">
    </div>
    <div class="row center">
        <div class="col s12 m12 l12">
            <h2>Bem-vindo ao Academic</h2>
            <h5>Esta é a página incial.</h5>
        </div>
    </div>
</div>
@endsection
