<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribes',
        ]);
       
        if ($validator->fails()) {
            return redirect('/')
                        ->withErrors('Такой адрес почты уже зарегистрирован');
        }
        Subscribe::create([
            
            'email' => $request->email,
            
        ]);

        return redirect()->route('home')->with('success', 'Рассылка добавлена');
    }
}
