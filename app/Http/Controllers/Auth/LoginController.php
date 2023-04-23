<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render('Auth/Login');
  }

  /**
   * Create auth instance
   */
  public function login(LoginRequest $request)
  {
    $credentials = $this->getCredentials($request->username) + array('password' => $request->password);

    if (Auth::attempt($credentials, $request->remember)) {
      $request->session()->regenerate();

      return redirect()->route(Auth::user()->is_admin ? 'products.index' : 'dashboard');
    }

    return back()->with(array(
      'message' => 'The provided credentials do not match our records.'
    ));
  }

  public function getCredentials($username): array
  {
    $columnIdentifier = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $user = User::where($columnIdentifier, $username)->first();

    if ($columnIdentifier === 'email' && $user->is_admin) {
      return array(
        'email' => $username
      );
    }

    return array(
      'username' => $username
    );
  }
}
