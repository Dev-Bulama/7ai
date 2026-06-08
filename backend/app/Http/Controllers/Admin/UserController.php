<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');
        if ($s = $request->search) $query->where('name','like',"%$s%")->orWhere('email','like',"%$s%");
        if ($r = $request->role) $query->role($r);
        $users = $query->latest()->paginate(20);
        $roles = Role::all();
        return view('admin.users.index', compact('users','roles'));
    }

    public function show(User $user)
    {
        $user->load('roles','projects','tickets','invoices','subscriptions');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user) {
        $roles = Role::all();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate(['name'=>'required','email'=>'required|email|unique:users,email,'.$user->id,'is_active'=>'boolean','country'=>'nullable|string','phone'=>'nullable|string']);
        $user->update($data);
        if ($request->roles) $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}
