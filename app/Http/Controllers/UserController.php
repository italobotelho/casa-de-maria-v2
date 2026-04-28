<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // Obtém o usuário autenticado
        $user = Auth::user();
        return view('perfil.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Valida os dados recebidos para atualização do perfil
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        // Atualiza os dados do usuário
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Informações do perfil atualizadas com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        // Valida os dados recebidos para atualização da senha
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verifica se a senha atual está correta
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->current_password])) {
            return redirect()->route('perfil.index')->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        // Atualiza a senha
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Senha atualizada com sucesso!');
    }
}