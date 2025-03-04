<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use App\Mail\VerificationCode;


class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => Str::random(6),
        ]);

        // Enviar correo de verificación
        Mail::to($user->email)->send(new VerificationEmail($user));

        return redirect()->route('login')->with('success', 'Por favor verifica tu correo electrónico.');
    }

    // Verificar correo electrónico
    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        if (sha1($user->email) === $hash) {
            $user->is_active = true;
            $user->save();
            return redirect()->route('login')->with('success', 'Correo verificado correctamente.');
        }

        return redirect()->route('login')->with('error', 'Enlace de verificación inválido.');
    }

    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->is_active) {
                return redirect()->route('login')->with('error', 'Por favor verifica tu correo electrónico.');
            }

            // Generar y enviar código de verificación
            $verificationCode = Str::random(6); // Genera un código aleatorio de 6 caracteres
            $user->verification_code = Hash::make($verificationCode); // Hashea el código
            $user->save();

            
            // Enviar el código sin hashear por correo (el usuario debe recibir el código original)
            Mail::to($user->email)->send(new VerificationCode($user, $verificationCode));

            return view('auth.verify-code', ['email' => $user->email]);
        }

        return redirect()->route('login')->with('error', 'Credenciales inválidas.');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6', // Asegúrate de que el código tenga 6 caracteres
        ]);
    
        // Buscar al usuario por su correo electrónico
        $user = User::where('email', $request->email)->first();
    
        // Verificar si el usuario existe y si el código es correcto
        if ($user && Hash::check($request->code, $user->verification_code)) {
            // El código es correcto
            Auth::login($user); // Iniciar sesión
            return redirect()->route('welcome')->with('success', 'Código verificado correctamente.');
        }
    
        // Si el código es incorrecto o el usuario no existe
        return redirect()->back()->with('error', 'Código de verificación incorrecto.');
    }

    // Mostrar pantalla de bienvenida
    public function welcome()
    {
        return view('welcome');
    }
}
