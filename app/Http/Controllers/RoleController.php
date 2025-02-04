<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{

    // public function index()
    // {
    //     $usuarios = User::with(['roles', 'permissions'])->paginate(10);
    //     return view('roles.index', compact('usuarios'));
    // }
    public function index()
    {
        $usuarios = User::with(['roles', 'permissions'])->paginate(10);
        $roles = Role::all();
        $permisos = Permission::all();

        return view('roles.index', compact('usuarios', 'roles', 'permisos'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all();
        $permisos = Permission::all();
        return view('roles.create', compact('roles', 'permisos'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos con su rol y permisos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permissions,id',
        ]);

        $usuario = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $usuario->roles()->sync($request->roles);

        if ($request->has('permisos')) {
            $usuario->syncPermissions($request->permisos);
        }

        return redirect()->route('roles.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un usuario.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        $permisos = Permission::all();
        return view('roles.edit', compact('usuario', 'roles', 'permisos'));
    }

    /**
     * Actualiza un usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permissions,id',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $usuario->roles()->sync($request->roles);
        $usuario->syncPermissions($request->permisos ?? []);

        return redirect()->route('roles.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->roles()->detach();
        $usuario->permissions()->detach();
        $usuario->delete();

        return redirect()->route('roles.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
