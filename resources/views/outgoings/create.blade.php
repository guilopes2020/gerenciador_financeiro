@extends('adminlte::page')

@section('title', 'Nova Despesa')

@section('content_header')
    <h1>Nova Despesa</h1>
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

<div class="card">
    <div class="card-body">
        <form action="{{route('outgoingsStore')}}" method="POST" class="form-horizontal">
        @csrf
        <input type="hidden" name="id_user" value="{{$user_id}}">
         <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Categoria</label>
                    <div class="controls">
                        <select name="category" id="category">
                            <option value="casa" selected>casa</option>
                            <option value="viagens">viagens</option>
                            <option value="superfulos">superfulos</option>
                            <option value="carro">carro</option>
                        </select>
                    </div>
                </div>
            </div>

        <div class="form-group row">
             <label class="col-sm-2 col-form-label">descrição</label>
            <div class="col-sm-8">
                <input type="text" name="description" value="{{old('description')}}" class="form-control @error('description') is-invalid @enderror">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Valor</label>
                <div class="col-sm-1">
                    <input type="number" step="0.01" name="value" value="{{old('value')}}" class="form-control @error('value') is-invalid @enderror">
                </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Vencimento</label>
                <div class="col-sm-2">
                    <input type="date" name="vencimento" value="{{old('value')}}" class="form-control @error('value') is-invalid @enderror">
                </div>
        </div>

        <div class="form-group row">
             <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
        </div>
        
    </form>
    </div>
</div>
    
@endsection