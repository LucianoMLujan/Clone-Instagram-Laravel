<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image.create');
    }

    public function save(Request $request) {

        //Validate
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required', 'image']
        ]);

        //Get data from form
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        
        //Assign data to new object
        $user = \Auth::user();
        $image = new Image();

        $image->user_id = $user->id;
        $image->description = $description;    

        //Upload image
        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')->with([
            'message' => 'La foto se ha sido subida correctamente.'
        ]);

    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }

    public function detail($id) {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && ($image->user->id == $user->id)) {
            //DELETE COMMENTS
            if($comments && (count($comments) > 0)) {
                foreach($comments as $comment) {
                    $comment->delete();
                }
            }

            //DELETE LIKES
            if($likes && (count($likes) > 0)) {
                foreach($likes as $like) {
                    $like->delete();
                }
            }

            //DELETE FILES
            storage::disk('images')->delete($image->image_path);

            //DELETE IMAGE RECORD
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente.');

        }else{
            $message = array('message' => 'La imagen no se ha podido borrar.');
        }

        return redirect()->route('home')->with($message);

    }

    public function edit($id) {
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && ($image->user->id == $user->id)) {
            return view('image.edit', [
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }

    }

    public function update(Request $request) {

        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['image']
        ]);

        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //Get object image from DB
        $image = Image::find($image_id);
        $image->description = $description;

        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        //Update Record
        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with(['message' => 'Imagen actualizada correctamente.']);
    }

}
