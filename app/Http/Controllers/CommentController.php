<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        $validate = $this->validate($request, [
            'image_id' =>  ['integer', 'required'],
            'content' => ['string', 'required']
        ]);
        
        //Get data from form
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Assing value to new object
        $comment = new Comment();
        
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        
        //Save comment in DB
        $comment->save();

        //Redirect to detail page
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with([
                            'message' => 'El comentario se publico correctamente.'
                         ]);
    }

    public function delete($id) {
        //Get data from identifier user
        $user = \Auth::user();

        //Get object from comment
        $comment = Comment::find($id);

        //Compare if i'm owner of the comment or the photo
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();

            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                                'message' => 'El comentario se elimino correctamente.'
                             ]);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                                'message' => 'El comentario no se pudo eliminar.'
                             ]);
        }

    }

}
