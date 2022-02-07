
@extends('adminlte::page')

@section('title', 'Entradas')

@section('content_header')
    <h1>Resultado da pesquisa</h1>
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
    <div class="alert alert-info">
        
        {{session('warning')}}
        
    </div>
@endif

    <div class="card">
        <div class="card-body">
            @if(count($results) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result )
                        <?php $result->created = date('d/m/Y', strtotime($result->created)); ?>
                            <tr>
                                <td>{{$result->category}}</td>
                                <td>{{$result->created}}</td>
                                <td>{{$result->description}}</td>
                                <td>{{$result->value}}</td>
                                <td>
                                    <a href="{{ route('entriesEdit', ['id' => $result->id]) }}" class="btn btn-sm btn-info">Editar</a>
                                    <form class="d-inline" method="POST" action="{{route('entriesDestroy', ['id' => $result->id])}}" onsubmit="return confirm('tem certeza que deseja excluir esta entrada?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <h4 style="text-align: center; color: #ccc; ">não foi encontrado nada referente a <strong>{{$search}}</strong></h4>
            @endif
        </div>
    </div>
    {{ $results->links() }}
    
@endsection