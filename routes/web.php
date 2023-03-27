<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });




Route::group(['middleware' => ['auth']],function(){

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');


    Route::post('/posts',[PostController::class,'store'])->name('posts.store');
    
    
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    
    
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    
    
    Route::delete('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
    
    
    Route::put('/posts', [PostController::class, 'update'])->name('posts.update');


    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

});


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get("/posts/removeOld",[PostController::class, "removeOldPosts"]);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/auth/github/redirect',[PostController::class,'githubredirect'])->name('githublogin');
Route::get('/auth/github/callback',[PostController::class,'githubcallback']);

Route::get('/auth/google/redirect',[PostController::class,'googleredirect'])->name('googlelogin');
Route::get('/auth/google/callback',[PostController::class,'googlecallback']);