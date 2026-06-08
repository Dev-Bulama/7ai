<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm() { return view('auth.login'); }
    public function login(Request $request)
    {
        $credentials = $request->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user->update(['last_login_at'=>now()]);
            if ($user->hasRole(['super-admin','admin','marketing-manager','content-manager','support-staff'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }
        return back()->withErrors(['email'=>'Invalid credentials.'])->withInput();
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
