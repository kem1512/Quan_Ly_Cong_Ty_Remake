<?php

use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WareHousesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Department;
use Illuminate\Http\Request;

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\EquimentTypeController;
use App\Http\Controllers\EquimentsController;
use App\Http\Controllers\PositionController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('addnhansu');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

// Route::get('/personnel/delete', [App\Http\Controllers\PersonnelController::class, 'destroy'])->name('delete');
// Route::post('/personnel/add', [App\Http\Controllers\PersonnelController::class, 'store'])->name('create.user');

Route::group(['middleware' => 'auth'], function () {
	Route::get('department', [DepartmentController::class, 'index'])->name('department');
	Route::get('overview', [DepartmentController::class, 'overview'])->name('overview');
	Route::get('getEmployeeInDepartment/{id?}', [DepartmentController::class, 'getEmployeeInDepartment']);
	Route::get('get_departments', [DepartmentController::class, 'get_departments']);
	Route::post('search', [DepartmentController::class, 'search'])->name('department.search');
	Route::get('filter', [DepartmentController::class, 'filter'])->name('department.filter');
	Route::post('department', [DepartmentController::class, 'create_or_update'])->name('department.create_or_update');
	Route::delete('department', [DepartmentController::class, 'delete'])->name('department.delete');

	Route::post('searchUser', [DepartmentController::class, 'searchUsers'])->name('department.searchUsers');
	Route::get('department/{id?}', [DepartmentController::class, 'display'])->name('department.display');
	Route::get('department/user/{id?}', [DepartmentController::class, 'user'])->name('department.user');
	Route::get('department/get_users/{id?}/{user_max?}', [DepartmentController::class, 'get_users'])->name('department.get_users');
	Route::post('addUser', [DepartmentController::class, 'addUser'])->name('department.addUser');
	Route::post('deleteUser', [DepartmentController::class, 'deleteUser'])->name('department.deleteUser');
	Route::post('updateUser', [DepartmentController::class, 'updateUser'])->name('department.updateUser');

	Route::get('position', [PositionController::class, 'index'])->name("position");
	Route::get('get_position', [PositionController::class, 'get_positions']);
	Route::post('delete_position', [PositionController::class, 'delete_position'])->name('department.delete_position');
	Route::post('delete_nominee', [PositionController::class, 'delete_nominee'])->name('department.delete_nominee');
	Route::post('update_position', [PositionController::class, 'update_position'])->name('department.update_position');
	Route::post('update_nominee', [PositionController::class, 'update_nominee'])->name('department.update_nominee');
	Route::post('add_position', [PositionController::class, 'add_position'])->name('department.add_position');
	Route::post('add_nominee', [PositionController::class, 'add_nominee'])->name('department.add_nominee');

	//personnel
	Route::get('/personnel', [PersonnelController::class, 'show'])->name('personnel');
	Route::get('/personnel', [App\Http\Controllers\Admin\PersonnelController::class, 'index'])->name('personnel.index');
	Route::get('/personnel/edit', [App\Http\Controllers\Admin\PersonnelController::class, 'edit'])->name('personnel.edit');
	Route::delete('/personnel', [App\Http\Controllers\Admin\PersonnelController::class, 'destroy'])->name('delete');
	Route::post('/personnel/add', [App\Http\Controllers\Admin\PersonnelController::class, 'store'])->name('create.user');
	Route::post('/personnel', [App\Http\Controllers\Admin\PersonnelController::class, 'update'])->name('update.user');
	Route::get('/personnel/search', [App\Http\Controllers\Admin\PersonnelController::class, 'search'])->name('Search');
	Route::post('/personnel/search-interviewer', [App\Http\Controllers\Admin\PersonnelController::class, 'search_interviewer'])->name('search_interviewer');
	Route::get('/personnel/search-cv', [App\Http\Controllers\Admin\PersonnelController::class, 'search_cv'])->name('search_cv');
	Route::post('/personnel/profile', [App\Http\Controllers\UserProfileController::class, 'update_profile'])->name('update.profile');
	Route::post('/personnel/level', [App\Http\Controllers\Admin\PersonnelController::class, 'update_level'])->name('update.level');
	Route::get('/personnel/fillter', [App\Http\Controllers\Admin\PersonnelController::class, 'fillter'])->name('fillter');
	Route::get('/personnel/fillter-cv', [App\Http\Controllers\Admin\PersonnelController::class, 'fillter_cv'])->name('fillter_cv');
	Route::get('/personnel/nominees', [App\Http\Controllers\Admin\PersonnelController::class, 'nominees'])->name('nominees');
	Route::get('/personnel/nominees-first', [App\Http\Controllers\Admin\PersonnelController::class, 'nominees_first'])->name('nominees_first');
	Route::get('/personnel/nominees-cv', [App\Http\Controllers\Admin\PersonnelController::class, 'nominees_cv'])->name('nominees_cv');
	Route::get('/personnel/cv', [App\Http\Controllers\Admin\PersonnelController::class, 'getAllCVT'])->name('getcv');
	Route::get('/personnel/interview', [App\Http\Controllers\Admin\PersonnelController::class, 'getAllInter'])->name('getcv');
	Route::get('/personnel/cv-id', [App\Http\Controllers\Admin\PersonnelController::class, 'getCVbyID'])->name('getCVbyID');
	Route::post('/personnel/cv-id', [App\Http\Controllers\Admin\PersonnelController::class, 'update_status_cv'])->name('update_status_cv');
	Route::post('/personnel/cv', [App\Http\Controllers\Admin\PersonnelController::class, 'saveCV'])->name('savecv');
	Route::post('/personnel/cv-u', [App\Http\Controllers\Admin\PersonnelController::class, 'update_cv'])->name('update_cv');
	Route::get('/personnel/cv-u', [App\Http\Controllers\Admin\PersonnelController::class, 'get_cv_update'])->name('get_cv_update');
	Route::post('/personnel/cv-update', [App\Http\Controllers\Admin\PersonnelController::class, 'update_cv_all'])->name('update_cv_all');
	Route::post('/personnel/interview', [App\Http\Controllers\Admin\PersonnelController::class, 'Add_interview'])->name('Add_interview');

	Route::group(
		['middleware' => 'auth'],
		function () {
			//Route::get('department', 'DepartmentController@Index');
			//Route thiết bị
			//Loại thiết bị
			Route::group(
				['prefix' => 'equimenttype'],
				function () {
					Route::get(
						'/',
						function () {
							return view('pages.Equiments.Equiment_Type.Index');
						}
					)->name('equimenttype');
					Route::get('get/{perpage?}/{orderby?}/{keyword?}', [EquimentTypeController::class, 'Get']);
					Route::post('post', [EquimentTypeController::class, 'Post']);
					Route::get('delete/{id?}', [EquimentTypeController::class, 'Delete']);
					Route::get('getbyid/{id?}', [EquimentTypeController::class, 'Get_By_Id']);
					Route::post('update/{id?}', [EquimentTypeController::class, 'Update']);
				}
			);

			//Kho
			Route::group(
				['prefix' => 'warehouse'],
				function () {
					Route::get(
						'/',
						function () {
							return view('pages.Equiments.warehouse.wavehouse');
						}
					)->name('warehouse');
					Route::get('get/{perpage?}/{orderby?}/{keyword?}', [WareHousesController::class, 'Get']);
					Route::get('delete/{id?}', [WareHousesController::class, 'Delete']);
					Route::get('getbyid/{id?}', [WareHousesController::class, 'GetById']);
					Route::post('post', [WareHousesController::class, 'Create']);
					Route::post('update/{id?}', [WareHousesController::class, 'Update']);
					Route::get('getequipment/{perpage?}/{currentpage?}/{id?}/{keyword?}', [WareHousesController::class, 'GetEquiments']);
				}
			);

			//Thiết bị
			Route::group(
				['prefix' => 'equiment'],
				function () {
					Route::get('/', [EquimentsController::class, 'Index'])->name('equiment');
					Route::get('get/{perpage?}/{currentpage?}/{status?}/{keyword?}', [EquimentsController::class, 'Get']);
					Route::post('post', [EquimentsController::class, 'Create']);
					Route::get('delete/{id?}', [EquimentsController::class, 'Delete']);
					Route::get('getbyid/{id?}', [EquimentsController::class, 'GetById']);
					Route::post('update/{id?}', [EquimentsController::class, 'Update']);
				}
			);

			//Chuyển giao
			Route::group(
				['prefix' => 'transfer'],
				function () {
					Route::get(
						'/',
						function () {
							$user = Auth::user();
							return view('pages.Equiments.Transfer.transfer', compact('user'));
						}
					)->name('transfer');
					Route::get('/getnhansu/{id?}', [TransferController::class, 'GetNhanSu']);
				}
			);
			//End route thiết bị
			Route::post(
				'get_departments',
				function (Request $request) {
					$search = $request->search;

					if ($search == '') {
						$departments = Department::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
					} else {
						$departments = Department::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
					}

					$response = array();
					foreach ($departments as $department) {
						$response[] = array("value" => $department->id, "label" => $department->name);
					}

					return response()->json($response);
				}
			)->name('department.get_departments');
			// Route::post('department', [DepartmentController::class, 'create'])->name('department.create');
			Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
			Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
			Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
			Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
			Route::get('/{page}', [PageController::class, 'index'])->name('page');
			Route::post('logout', [LoginController::class, 'logout'])->name('logout');
		}
	);
});
