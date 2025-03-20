<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $query = App\Models\Student::query();
    
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%");
        });
    }
    
    if (request('department')) {
        $query->where('department', request('department'));
    }
    
    if (request('session')) {
        $query->where('session', request('session'));
    }

    if (request('blood_group')) {
        $query->where('blood_group', request('blood_group'));
    }

    if (request('gender')) {
        $query->where('gender', request('gender'));
    }
    
    $students = $query->paginate(21);
    $departments = App\Models\Student::distinct('department')->pluck('department');
    $sessions = App\Models\Student::distinct('session')->pluck('session');
    $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    
    return view('welcome', compact('students', 'departments', 'sessions', 'bloodGroups'));
});

Route::middleware(['auth'])->group(function () {
    Route::post('/students', [App\Http\Controllers\StudentController::class, 'store'])->name('students.store');
Route::get('/students/create', [App\Http\Controllers\StudentController::class, 'create'])->name('students.create');
Route::get('/students/{student}/edit', [App\Http\Controllers\StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('students.destroy');
});

Route::get('/dashboard', function () {
    $query = App\Models\Student::query();
    
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%");
        });
    }
    
    if (request('department')) {
        $query->where('department', request('department'));
    }
    
    if (request('session')) {
        $query->where('session', request('session'));
    }

    $students = $query->paginate(20);
    $departments = App\Models\Student::distinct('department')->pluck('department');
    $sessions = App\Models\Student::distinct('session')->pluck('session');
    return view('dashboard', compact('students', 'departments', 'sessions'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
