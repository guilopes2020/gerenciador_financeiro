
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
                            <?php 
                                $result->created = date('d/m/Y', strtotime($result->created)); 
                                $result->vencimento = date('d/m/Y', strtotime($result->vencimento));
                            ?>
                            <tr @if($result->paga === 1) class="btn-success"@endif>
                                <td>@if($result->paga === 1)<del>{{$result->category}}<del> @else {{$result->category}} @endif</td>
                                <td>@if($result->paga === 1)<del>{{$result->created}}<del> @else {{$result->created}} @endif</td>
                                <td>@if($result->paga === 1)<del>{{$result->description}}<del> @else {{$result->description}} @endif </td>
                                <td>@if($result->paga === 1)<del>{{'R$ '.number_format($result->value, 2, ',', '.')}}</del> @else {{'R$ '.number_format($result->value, 2, ',', '.')}} @endif </td>
                                <td>@if($result->paga === 1) <del>{{$result->vencimento}}</del> @else {{$result->vencimento}} @endif </td>
                                <td>
                                    <a href="{{ route('outgoingsEdit', ['id' => $result->id]) }}" class="btn btn-sm btn-info">Editar</a>

                                    <form class="d-inline" method="POST" action="{{route('outgoingsDestroy', ['id' => $result->id])}}" onsubmit="return confirm('tem certeza que deseja excluir esta despesa?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                    <form class="d-inline" method="POST" action="{{route('outgoingsPay', ['id' => $result->id])}}">
                                        @method('PUT')
                                        @csrf
                                        <button class="btn btn-sm btn-info">@if($result->paga === 1)marcar como não paga @else marcar como paga @endif </button>
                                    </form>

                                </td>
                            </tr>      
                        @endforeach
                    </tbody>
                </table>
                @else
                    <h4 style="text-align: center; color: #ccc; ">não foi encontrado nada referente a <strong>{{$search['category']}}</strong></h4>
            @endif
        </div>
    </div>
    {{ $results->links() }}
    
@endsection