<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Models\User ;
use App\Http\Requests\UserStore;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->paginate(5);
        return view('users.showall', compact('data'))->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $availableCar = event(new UserCreated($user));

        return view('users.create', compact('availableCar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStore $request)
    {
        $input = $request-> validated();
        $input['password']= bcrypt($input['password']);

        $user = User::create($input);

        // Déclencher l'événement UserCreated pour créer une voiture associée
        event(new UserCreated($user));

        return redirect()->route('user.index')->with('success', 'User created successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::find($id);
        return view('users.editUser',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStore $request, string $id)
    {
        $user = User::where('id',$id);
        $input = $request-> validated();

        // Ne mettre à jour le mot de passe que s'il est fourni
        if(empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = bcrypt($input['password']);
        }

        $user->update($input);
        return redirect()->route('user.index')->with('success','User updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully !');
    }
}
