@extends('adminlte::page')

@section('title', 'Perfil do Usuário')

@section('content_header')
    <h1>Meu Perfil</h1>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        <h5>
            <i class="icon fas fa-ban"></i>
            Erro!
        </h5>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-success">
        
        {{session('warning')}}
        
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{route('profileUpdate')}}" method="POST" class="form-horizontal">
        @method('PUT')
        @csrf
        
        
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label">Nome</label>
                <div class="col-sm-8">
                    <input type="text" name="name" value="{{$user->name}}" class="form-control @error('category') is-invalid @enderror">
                </div>
            </div>
        </div>

        <div class="form-group row">
             <label class="col-sm-2 col-form-label">E-mail</label>
            <div class="col-sm-8">
                <input type="email" name="email" value="{{$user->email}}" class="form-control @error('description') is-invalid @enderror">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Senha</label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control @error('value') is-invalid @enderror">
                </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Repita a Senha</label>
                <div class="col-sm-8">
                    <input type="password" name="password_confirmation" class="form-control @error('value') is-invalid @enderror">
                </div>
        </div>

        <div class="form-group row">
             <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <input type="submit" value="Salvar" class="btn btn-success">
                </div>
        </div>
        
    </form>
    </div>
</div>
    
@endsection