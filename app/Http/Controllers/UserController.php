<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
<<<<<<< HEAD
use App\Models\Car;
=======
>>>>>>> 123a6a7de7714489254e4a3587357f3e8b33b3ab
use App\Models\User ;
use App\Http\Requests\UserStore;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


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

    public function store(Request $request)
    {
<<<<<<< HEAD
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8', // Exemple de règle de validation pour le mot de passe
            // Ajoutez d'autres règles de validation pour les autres champs
        ]);

        // Récupérer les données du formulaire
        $input = $request->all();

// Crypter le mot de passe avec bcrypt
        $input['password'] = bcrypt($input['password']);

// Créer un nouvel utilisateur
        $user = User::create($input);

// Déclencher l'événement UserCreated
        event(new UserCreated($user));

// Créer une voiture et l'associer à l'utilisateur
        $car = new Car([
            'model_id' => $request->model_id, // Assurez-vous que vous avez le model_id du modèle de voiture
            'color' => $request->color,
            'matricule' => $request->matricule,
        ]);
        $user->car()->save($car);

// Rediriger l'utilisateur vers une page de confirmation ou une autre page
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès !');
=======
        $input = $request-> validated();
        $input['password']= bcrypt($input['password']);

        $user = User::create($input);

        // Déclencher l'événement UserCreated pour créer une voiture associée
        event(new UserCreated($user));

        return redirect()->route('user.index')->with('success', 'User created successfully !');
>>>>>>> 123a6a7de7714489254e4a3587357f3e8b33b3ab
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
