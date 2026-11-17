<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\User;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    protected function getAllGifts(){
        $prendas= Gift::join('users', 'prendasnatal.user_id','=' ,'users.id')
        ->select('prendasnatal.id', 'prendasnatal.nome_prenda', 'prendasnatal.valor_previsto', 'users.name as user_name', 'prendasnatal.valor_gasto')
        ->get();
        return $prendas;
    }

     public function deletePrendas(int $id){
        Gift::where('id',$id)->delete();
        return back();
    }

    public function updatePrendas(Request $request) {
            $request->validate([
            'nome_prenda' => 'required|string|max:50',
            'valor_previsto' => 'required|numeric|min:0|decimal:0,2',
            'user_id' => 'required|integer|exists:users,id',
            'valor_gasto' => 'nullable|numeric|min:0|decimal:0,2',
        ]);
        Gift::where('id', $request->id)->update([
            'nome_prenda'=> $request->nome_prenda,
            'valor_previsto'=> $request->valor_previsto,
            'user_id'=> $request->user_id,
            'valor_gasto'=> $request->valor_gasto,
        ]);
        return redirect()->route('gifts.all')->with('message', 'Prenda actualizada com sucesso!');
    }

    // public function giftList(){
    //     $prendas=$this->getAllGifts();
    //     return view('gifts.giftList', compact('prendas'));
    // }

    // public function editPrendas(int $id) {
    //     $giftInfo = Gift::where('id', $id)->select('nome_prenda','valor_previsto', 'user_id', 'valor_gasto')->first();
    //     $prendas = $this->getAllGifts();
    //     $quem_deu = User::select('id', 'name')->get(); // para vermos os users da tabela users no form
    //     return view('gifts.giftList', compact('giftInfo', 'prendas', 'quem_deu'));
    // }

    // 16/11 22H07 - em vez de ter duas funcoes, que apontam para a mesma blade posso ter apenas uma funcao que engloba as duas?
    // editPrendas necessita do id, giftList nao, ver amanha como se faz um parametro opcional (no JS para um parametro ser opcinal seria por exemplo id=null, no java seria com sobrecarga de metodos e no PHP é algo semelhante ao JS $id = null, ver se para laravel é =)

    // 17/11 https://laravel.com/framework/docs/13.x/routing#parameters-optional-parameters
    // parametros opcionais para funcoes, é igual ao php


    public function giftList(?int $id = null){
        $prendas=$this->getAllGifts();
        $giftInfo = null;
    if ($id !== null) {
        $giftInfo = Gift::where('id', $id)
            ->select('id', 'nome_prenda', 'valor_previsto', 'user_id', 'valor_gasto')
            ->firstOrFail(); // https://laravel.com/framework/docs/13.x/collections#method-first-or-fail
        }
        $quem_deu = User::select('id', 'name')->get(); // para vermos os users da tabela users no form
        foreach ($prendas as $prenda) {
            $prenda->diferencaValores = $prenda->valor_previsto - $prenda->valor_gasto;
        }
    return view('gifts.giftList', compact('giftInfo', 'prendas', 'quem_deu'));
    }

    public function storePrendas(Request $request){
           //validar os dados no servidor
        $request->validate([
            'nome_prenda' => 'required|string|max:50',
            'valor_previsto' => 'required|numeric|min:0|decimal:0,2',
            'user_id' => 'required|integer|exists:users,id',
            'valor_gasto' => 'nullable|numeric|min:0|decimal:0,2',
        ]);

     //depois de validados, inserir na bd
        Gift::insert([
            'nome_prenda'=> $request->nome_prenda,
            'valor_previsto'=> $request->valor_previsto,
            'user_id' => $request->user_id,
            'valor_gasto'=> $request->valor_gasto

        ]);

          return redirect()->route('gifts.all')->with('message', 'Prenda adicionada com sucesso!');
          }


}
