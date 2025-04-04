<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('patient.auth.login');
    }

    /**
     * Traite la demande de connexion
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'password.required' => 'Le mot de passe est obligatoire',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = false; // Force à false pour éviter l'utilisation de remember_token

        // Vérifie si l'utilisateur existe et est un patient
        $user = User::where('email', $request->email)->first();
        if (!$user || $user->user_type !== 'PATIENT') {
            return redirect()->back()
                ->with('error', 'Ces identifiants ne correspondent pas à un compte patient')
                ->withInput($request->except('password'));
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('patient.home'));
        }

        return redirect()->back()
            ->with('error', 'Les identifiants fournis ne correspondent à aucun utilisateur')
            ->withInput($request->except('password'));
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('patient.auth.register');
    }

    /**
     * Traite la demande d'inscription
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required',
        ], [
            'full_name.required' => 'Le nom complet est obligatoire',
            'username.required' => 'Le nom d\'utilisateur est obligatoire',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'terms.required' => 'Vous devez accepter les conditions d\'utilisation',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'user_type' => 'PATIENT',
            'full_name' => $request->full_name,
        ]);

        Auth::login($user);
        return redirect()->route('patient.home')->with('success', 'Votre compte a été créé avec succès');
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('patient.home');
    }

    /**
     * Redirige vers le fournisseur OAuth
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Gère le callback du fournisseur OAuth
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('patient.auth.login')->with('error', 'Une erreur est survenue lors de la connexion avec ' . ucfirst($provider));
        }

        // Vérifie si l'utilisateur existe déjà
        $user = User::where('email', $socialUser->getEmail())->first();

        // Si l'utilisateur n'existe pas, on le crée
        if (!$user) {
            $user = User::create([
                'username' => $this->generateUniqueUsername($socialUser->getNickname() ?? $socialUser->getName()),
                'email' => $socialUser->getEmail(),
                'password' => Str::random(16),
                'user_type' => 'PATIENT',
                'full_name' => $socialUser->getName(),
            ]);
        } elseif ($user->user_type !== 'PATIENT') {
            return redirect()->route('patient.auth.login')
                ->with('error', 'Cette adresse email est déjà utilisée avec un autre type de compte');
        }

        Auth::login($user);
        return redirect()->route('patient.home');
    }

    /**
     * Génère un nom d'utilisateur unique
     */
    private function generateUniqueUsername($name)
    {
        $username = Str::slug($name);
        $count = 1;

        // Vérifie si le nom d'utilisateur existe déjà
        while (User::where('username', $username)->exists()) {
            $username = Str::slug($name) . $count;
            $count++;
        }

        return $username;
    }
} 