<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;

// Este tipo de rotas é semelhante às que já usei anteriormente (em NOTASANDRE.txt), mas tem uma diferença importante: em vez de executar uma função anónima diretamente na rota, chama um método de um Controller (controlador).

Route::get('/', [UtilController::class, 'loadHomepage' ])->name('welcome');

// rota de homepage
Route::get('/homepage', [UtilController::class, 'loadHomepage' ]) ->name('home');

// USERS
// rotas de users (load user e add users)
Route::get('/users', [UserController::class, 'allUsers' ])->name('users.all');

Route::get('/addUsers', [UserController::class, 'addUsers' ])->name('users.add');

// rota de editar users
Route::get('/edit-users/{id}',[UserController::class, 'editUsers'] )->name('users.edit')->middleware('auth');


// rota de apagar users
Route::get('/delete-users/{id}',[UserController::class, 'deleteUsers'] )->name('users.delete');

Route::post('/store-users', [UserController::class, 'storeUser'])->name('users.store');

//rota de actualizar users
Route::put('/update-user', [UserController::class, 'updateUser'])->name('users.update');

// TASKS
// rota de tarefas /tasks é o endereço , apresentarTasks é a funcao que devolve a view allTasks.blade e estou a chamar a isto tasks.all
Route::get('/addTasks', [TaskController::class, 'addTasks' ])->name('tasks.add');
Route::post('/store-tasks', [TaskController::class, 'storeTask'])->name('tasks.store');
Route::get('/tasks', [TaskController::class, 'allTasks' ])->name('tasks.all');
// rota de editar tasks
Route::get('/editTasks/{id}',[TaskController::class, 'editTasks'] )->name('tasks.edit');
// rota de apagar tasks
Route::get('/delete-tasks/{id}',[TaskController::class, 'deleteTasks'] )->name('tasks.delete');

// //////////////////////////////Prendas
Route::delete('/delete-prendas/{id}',[GiftController::class, 'deletePrendas'] )->name('prendas.delete');
// As duas abaixo enviam a mesma funcao
Route::get('/prendas', [GiftController::class, 'giftList' ])->name('gifts.all');
Route::get('/edit-prendas/{id}',[GiftController::class, 'giftList'] )->name('prendas.edit');

// Poderiamos criar uma rota com parametro opcional como vimos em  https://laravel.com/framework/docs/13.x/routing#parameters-optional-parameters  : No entanto vou manter as duas acima
// Route::get('/prendas/{id?}', [GiftController::class, 'giftList'])->name('gifts.all');

Route::put('/update-prendas', [GiftController::class, 'updatePrendas'])->name('prendas.update');

Route::post('/store-prendas', [GiftController::class, 'storePrendas'])->name('prendas.store');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

//rota fallback
Route::fallback(function(){
    return view('utils.fallback');
});


