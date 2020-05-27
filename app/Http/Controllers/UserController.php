<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {
        //Get identified user
        $user = \Auth::user();
        $id = $user->id;

        //Validate edit form
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
        ]);

        //Get data from form
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //Assign new values to user object
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //Upload avatar
        $image_path = $request->file('image_path');
        if($image_path){
            //Set unique name
            $image_name_path = time().$image_path->getClientOriginalName();
            //Save image on folder
            Storage::disk('users')->put($image_name_path, File::get($image_path));
            //Set image name
            $user->image = $image_name_path;
        }
        
        //Update data on database
        $user->update();

        //Redirect to config after update
        return redirect()->route('config')
                         ->with(['message' => 'Usuario actualizado correctamente.']);
    }

    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);

        return new Response($file, 200);
    }

}
