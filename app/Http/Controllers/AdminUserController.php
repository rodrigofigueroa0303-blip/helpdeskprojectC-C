<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Muestra el dashboard de administración con la lista de usuarios.
     * Esto mapea directamente a la URL /admin (HTTP GET)
     */
    public function dashboard(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Redirige al dashboard (la edición se hace vía modal).
     */
    public function edit(User $user)
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Registra un nuevo usuario desde el formulario del Dashboard.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|string|in:user,admin',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('ok', 'Usuario creado exitosamente.');
    }

    /**
     * Actualiza un usuario existente (llamado desde el Modal de Edición).
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|string|in:user,admin',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('ok', 'Usuario actualizado con éxito.');
    }


    /**
     * Elimina un usuario (llamado desde el Modal de Confirmación).
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')->with('error', 'No puedes eliminar tu propia cuenta en sesión.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('ok', 'Usuario eliminado correctamente.');
    }
}