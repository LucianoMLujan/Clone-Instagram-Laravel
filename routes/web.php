<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use App\Image;

Route::get('/', function () {

    /*$images = Image::all();
    foreach($images as $image) {
        echo $image->image_path."<br/>";
        echo $image->description."<br/>";
        echo $image->user->name." ".$image->user->surname."<br/>";

        if(count($image->comments) > 0) {
            echo "<h4>Comentarios</h4>";
            foreach($image->comments as $comment) {
                echo $comment->user->nick." | ".$comment->content.'<br/>';
            }
        }
        
        echo 'Likes: '. count($image->likes);

        echo "<hr/>";
    }

    die();*/

    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//USER ROUTES
Route::get('/configuracion', 'UserController@config')->name('config');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/profile/{id}', 'UserController@profile')->name('user.profile');
Route::get('/friends/{search?}', 'UserController@index')->name('user.index');

//IMAGE ROUTES
Route::get('/upload-image', 'ImageController@create')->name('image.upload');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update', 'ImageController@update')->name('image.update');

//COMMENT ROUTES
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//LIKE ROUTES
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes.index');