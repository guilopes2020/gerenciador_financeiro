<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Outgoing;

class OutGoingController extends Controller

{

    protected $userLogged;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->userLogged = Auth::id();
        $outgoings = Outgoing::orderBy('id', 'DESC')->where('id_user', $this->userLogged)->paginate(5);
        return view('outgoings.outgoings', [
            'outgoings' => $outgoings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userLogged = Auth::id();
        return view('outgoings.create',[
            'user_id' => $this->userLogged
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'id_user',
            'category',
            'description',
            'value',
            'vencimento'
        ]);

        $validator = $this->validator($data);

        if ($data['value'] < 0) {
            $validator->errors()->add('value', 'o valor não pode ser negativo');
            return redirect()->route('outgoingsCreate')->withErrors($validator)->withInput();
        }

        if ($data['vencimento'] < now()) {
            $validator->errors()->add('vencimento', 'a data não poder ser no passado e nem ultrapassar 12 meses!');
            return redirect()->route('outgoingsCreate')->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            return redirect()->route('outgoingsCreate')->withErrors($validator)->withInput();
        }

        $outgoing = new Outgoing;
        $outgoing->id_user = $data['id_user'];
        $outgoing->category = $data['category'];
        $outgoing->created = date('Y-m-d h:i:s');
        $outgoing->description = $data['description'];
        $outgoing->value = $data['value'];
        $outgoing->vencimento = date($data['vencimento']);
        $outgoing->save();

        return redirect()->route('outgoingsIndex')->with('warning', 'Despesa criada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userLogged = Auth::id();
        $outgoing = Outgoing::find($id);

        if ($outgoing == null) {
            return redirect()->route('outgoingsIndex')->withErrors('Despesa inexistente');; 
        } elseif($outgoing->id_user !== $this->userLogged) {
            return redirect()->route('outgoingsIndex')->withErrors('Essa Despesa não é sua, impossivel editar!'); 
        } else {
            return view('outgoings.edit', [
                'outgoing' => $outgoing
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'category',
            'description',
            'value',
            'vencimento'

        ]);

        $validator = $this->validator($data);

        if ($data['value'] < 0) {
            $validator->errors()->add('value', 'o valor não pode ser negativo');
            return redirect()->route('outgoingsCreate')->withErrors($validator)->withInput();
        }

        if ($data['vencimento'] < now()) {
            $validator->errors()->add('vencimento', 'a data não poder ser no passado e nem ultrapassar 12 meses!');
            return redirect()->route('outgoingsCreate')->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            return redirect()->route('outgoingsEdit', ['id' => $id])->withErrors($validator);
        }

        $outgoing = Outgoing::find($id);
        if ($outgoing == null) {
            return redirect()->route('outgoingsIndex')->withErrors('Despesa inexistente');
        } else {
            $outgoing->category = $data['category'];
            $outgoing->description = $data['description'];
            $outgoing->value = $data['value'];
            $outgoing->vencimento = $data['vencimento'];
            $outgoing->save();
            return redirect()->route('outgoingsIndex')->with('warning', 'Despesa alterada com sucesso');;
        }
    }

    public function pay($id) {
        $this->userLogged = Auth::id();
        $outgoing = Outgoing::find($id);
        if ($outgoing == null) {
            return redirect()->route('outgoingsIndex')->withErrors('Despesa inexistente');
        } elseif($outgoing->id_user !== $this->userLogged) {
            return redirect()->route('outgoingsIndex')->withErrors('Essa Despesa não é sua, impossivel editar!'); 
        } else {
            if ($outgoing->paga == 1) {
                $outgoing->paga = 0;
                $outgoing->save();
            } else {
                $outgoing->paga = 1;
                $outgoing->save();
            }
            return redirect()->route('outgoingsIndex');
        }
    }

    public function search(Request $request)
    {
        $this->userLogged = Auth::id();

        $search = $request->filter;
        $results = Outgoing::where([['description', 'like', '%'.$search.'%']])->where('id_user', $this->userLogged)->paginate(5);

       return view('outgoings.search', [
        'results' => $results,
        'search' => $search
    ]);
    }

    public function searchCategory(Request $request)
    {
        $this->userLogged = Auth::id();

        $search = $request->only([
            'category'
        ]);


        $results = Outgoing::where('category', $search['category'])->where('id_user', $this->userLogged)->paginate(5);

       return view('outgoings.searchCategory', [
        'results' => $results,
        'search' => $search
    ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userLogged = Auth::id();
        $outgoing = Outgoing::find($id);
        if ($outgoing == null) {
            return redirect()->route('outgoingsIndex')->withErrors('Despesa inexistente, nada foi excluído');
        } elseif($outgoing->id_user !== $this->userLogged) {
            return redirect()->route('outgoingsIndex')->withErrors('Despesa não pertence a você, nada deletado!');
        } else {
            $outgoing->delete();

            return redirect()->route('outgoingsIndex')->with('warning', 'A Despesa foi Excluída!');
        }
    }

    protected function validator(array $data) {
        return Validator::make($data, [
          'category' => ['required', 'string'],
          'description' => ['required', 'string', 'max:191'],
          'value' => ['required'],
          'vencimento' => ['required', 'date']
        ]);
    }
}
