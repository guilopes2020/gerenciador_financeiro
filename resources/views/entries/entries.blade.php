
@extends('adminlte::page')

@section('title', 'Entradas')

@section('content_header')
    <h1>Minhas entradas <a href="{{route('entriesCreate')}}" class="btn btn-sm btn-success">Nova entrada</a></h1>
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

    @if (count($entries) > 0)

        <div class="ml-auto p-2">
            <form action="{{route('entriesSearch')}}" method="get" class="for form inline">
                @csrf
                <input type="text" name="filter" placeholder="Buscar por Receita" class="form-control" required>
                <span class="mt-2"><button type="submit" class="btn btn-info mt-2 align-right">Pesquisar</button>
            </form>
        </div><br><br>
        <h5>Buscar por categoria</h5>

        <div class="ml-auto p-2">
            <form action="{{route('entriesSearchCategory')}}" method="post" class="for form inline">
                @csrf
                <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label">Categoria</label>
                            <div class="controls">
                                <select name="category" id="category">
                                    <option value="trabalho" selected>trabalho</option>
                                    <option value="alugueis">alugueis</option>
                                    <option value="freelas">freeelas</option>
                                    <option value="outros">outros</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <span class="mt-2"><button type="submit" class="btn btn-info mt-2 align-right">Pesquisar</button>
            </form>
        </div>

            <div class="card">
                <div class="card-body">
                    
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
                                @foreach ($entries as $entrie )
                                <?php $entrie->created = date('d/m/Y', strtotime($entrie->created)); ?>
                                    <tr>
                                        <td>{{$entrie->category}}</td>
                                        <td>{{$entrie->created}}</td>
                                        <td>{{$entrie->description}}</td>
                                        <td>{{'R$ '.number_format($entrie->value, 2, ',', '.')}}</td>
                                        <td>
                                            <a href="{{ route('entriesEdit', ['id' => $entrie->id]) }}" class="btn btn-sm btn-info">Editar</a>
                                            <form class="d-inline" method="POST" action="{{route('entriesDestroy', ['id' => $entrie->id])}}" onsubmit="return confirm('tem certeza que deseja excluir esta entrada?')">
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
                            <h4 style="text-align: center; color: #ccc; ">Você ainda não tem nenhuma entrada para ser listada, clique em nova entrada logo acima!</h4>
    @endif
            </div>
        </div>
        {{ $entries->links() }}
    
@endsection