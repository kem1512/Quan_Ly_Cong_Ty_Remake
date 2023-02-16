<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\nominee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PersonnelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $rq)
    {
        //active new user
        if (Auth::user()->status == 0) {
            $user = User::find(Auth::user()->id);
            $user->status = 1;
            $user->save();
        }
        //get user
        if ($rq->ajax()) {
            $data = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->select('users.*', 'departments.name')->paginate(7);
            $body = User::UserBuild($data);
            return response()->json(['body' => $body]);
        };
        $ucount = User::all()->count();
        $phongbans = Department::all();
        // dd($phongbans);
        $postions = Position::all();
        $level = Auth::user()->level;
        //join chỉ lấy phần chung | leftjoin lấy cả chung và riêng
        $nhansu = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->select('users.*', 'departments.name')->paginate(7);
        return view('pages.personnel.personnel', compact('phongbans', 'postions', 'nhansu', 'level', 'ucount'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $rq)
    {
        //get user by id , response to form update
        $id = $rq->id;
        $personneldetail = User::find($id);
        return response()->json(['status' => 'success', 'data' => $personneldetail]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // bug tuổi
        $user = User::findOrFail($request->id);
        $level = Auth::user()->level;
        if ($level == 0) {
            return response()->json(['status' => 'error', 'message' => 'Không thể thêm do không đủ quyền !']);
        }

        $age = floor((time() - strtotime($request->date_of_birth)) / 31556926);
        // dd($age);
        if ($age < 15) {
            return response()->json(['status' => 'error', 'message' => 'Tuổi của nhân sự phải lớn hơn 15 !']);
        }

        if ($user->email == $request->email) {
            $request->validate([
                'img_url' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000',
                'fullname' => 'required|min:3|max:255',
                'email' => 'required|email',
                'date_of_birth' => 'date|required',
                'recruitment_date' => 'required|date',
                'status' => 'required|max:2',
                'title' => 'required|min:3|max:100',
                'gender' => 'required|max:2',
                'phone' => 'min:5|max:15',
                'position_id' => 'min:1|max:4',
                'department_id' => 'required|max:5'
            ], [
                'fullname.min' => 'Tên phải có hơn 3 ký tự !',
                'fullname.required' => 'Tên không được để trống !',
                'email.email' => 'Email không đúng định dạng !',
                'email.required' => 'Email không được để trống !',
                'date_of_birth.required' => 'Ngày sinh không được để trống !',
                'date_of_birth.date' => 'Ngày sinh không đúng định dạng !',
                'recruitment_date.date' => 'Ngày tuyển dụng không đúng định dạng !',
                'recruitment_date.required' => 'Ngày tuyển dụng không được để trống !',
                'status.required' => 'Trạng Thái không được để trống !',
                'status.max' => 'Trạng Thái không được lớn hơn 2 ký tự !',
                'title.required' => 'Chức danh không được để trống !',
                'title.max' => 'Chức danh quá dài !',
                'title.min' => 'Chức danh quá ngắn !',
                'gender.required' => 'giới tính không để trống !',
                'gender.max' => 'sai định dạng giới tính !',
                'img_url.image' => 'File ảnh không đúng định dạng!',
                'img_url.mimes' => 'Ảnh phải có đuôi jpg,png,jpeg,gif,svg !',
                'img_url.max' => 'Dung lượng ảnh quá lớn !',
                'img_url.dimensions' => 'Ảnh quá lớn hoặc quá nhỏ !',
                'phone.min' => 'Số điện thoại quá ngắn !',
                'phone.max' => 'Số điện thoại quá dài !',
                'position_id.max' => 'Chức vụ lỗi !',
                'position_id.min' => 'Chức vụ lỗi !',
                'department_id.required' => 'Phòng ban không được trống !',
                'department_id.max' => 'Phòng ban quá dài !'
            ]);
        } else {
            $request->validate([
                'img_url' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000',
                'fullname' => 'required|min:3|max:255',
                'email' => 'required|email|unique:users,email',
                'date_of_birth' => 'date|required',
                'recruitment_date' => 'required|date',
                'status' => 'required|max:2',
                'title' => 'required|min:3|max:100',
                'gender' => 'required|max:2',
                'phone' => 'min:5|max:15',
                'position_id' => 'min:1|max:4',
                'department_id' => 'required|max:5'
            ], [
                'fullname.min' => 'Tên phải có hơn 3 ký tự !',
                'fullname.required' => 'Tên không được để trống !',
                'email.email' => 'Email không đúng định dạng !',
                'email.required' => 'Email không được để trống !',
                'date_of_birth.required' => 'Ngày sinh không được để trống !',
                'date_of_birth.date' => 'Ngày sinh không đúng định dạng !',
                'recruitment_date.date' => 'Ngày tuyển dụng không đúng định dạng !',
                'recruitment_date.required' => 'Ngày tuyển dụng không được để trống !',
                'status.required' => 'Trạng Thái không được để trống !',
                'status.max' => 'Trạng Thái không được lớn hơn 2 ký tự !',
                'title.required' => 'Chức danh không được để trống !',
                'title.max' => 'Chức danh quá dài !',
                'title.min' => 'Chức danh quá ngắn !',
                'gender.required' => 'giới tính không để trống !',
                'gender.max' => 'sai định dạng giới tính !',
                'img_url.image' => 'File ảnh không đúng định dạng!',
                'img_url.mimes' => 'Ảnh phải có đuôi jpg,png,jpeg,gif,svg !',
                'img_url.max' => 'Dung lượng ảnh quá lớn !',
                'img_url.dimensions' => 'Ảnh quá lớn hoặc quá nhỏ !',
                'phone.min' => 'Số điện thoại quá ngắn !',
                'phone.max' => 'Số điện thoại quá dài !',
                'position_id.max' => 'Chức vụ lỗi !',
                'position_id.min' => 'Chức vụ lỗi !',
                'department_id.required' => 'Phòng ban không được trống !',
                'department_id.max' => 'Phòng ban quá dài !',
                'email.unique' => 'Email đã tồn tại !'
            ]);
        }

        if (!$request->img_url == '') {
            $fileName = time() . '.' . $request->img_url->extension();
            $request->img_url->move(public_path('img'), $fileName);
            $user->img_url = $fileName;
        }
        // dd($user);
        $user->gender = $request->gender;
        $user->about = $request->about;
        $user->title = $request->title;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->department_id = $request->department_id;
        $user->date_of_birth = $request->date_of_birth;
        $user->position_id = $request->position_id;
        $user->recruitment_date = $request->recruitment_date;
        if ($request->status == 3 | $request->status == 4) {
            $request->validate(
                [
                    'about' => 'required|min:5|max:1000'
                ],
                [
                    'about.required' => 'Để đổi sang trạng thái này, bạn vui lòng nhập lý do !',
                    'about.min' => 'Lý do quá ngắn !',
                    'about.max' => 'Lý do quá dài !',
                ]
            );
        }
        $user->status = $request->status;
        $user->address = $request->address;
        $user->save();
        $nhansu2 = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->select('users.*', 'departments.name')->paginate(7);
        $body = User::UserBuild($nhansu2);
        return response()->json(['status' => 'succes', 'body' => $body]);
    }
    public function update_level(Request $request)
    {
        if (!Auth::user()->level == 2) {
            return response()->json(['status' => 'error', 'message' => 'Bạn không đủ thẩm quyền !']);
        } else {
            $user = User::find($request->id);
            $user->level = $request->level;
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Thay đổi đã được áp dụng !']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $rq)
    {
        //check quyền
        $level = Auth::user()->level;
        if ($level == 0) {
            return response()->json(['status' => 'error', 'message' => 'Không thể xóa do không đủ quyền !']);;
        }
        //check user
        $id = $rq->input('count_type');
        $userDelete = Auth::user()->id;
        if ($userDelete == $id) {
            return response()->json(['status' => 'error', 'message' => 'Bạn không thể xoá chính bạn !']);
        } else {
            //delete user by id
            $id = $rq->input('count_type');
            $nhansu =  User::find($id);
            $nhansu->delete();
            $nhansu2 = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->select('users.*', 'departments.name')->paginate(7);
            $body = User::UserBuild($nhansu2);
            return response()->json(['body' => $body]);
        }
    }


    public function search(Request $request)
    {
        //search by personnel_code , fullname and email
        $search = $request->search;
        $result = User::where('personnel_code', 'like', "%$search%")
            ->orWhere('fullname', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->leftjoin('departments', 'users.department_id', 'departments.id')
            ->select('users.*', 'departments.name')->paginate(7);
        $body = User::UserBuild($result);
        return response()->json(['body' => $body]);
    }

    public function fillter(Request $request)
    {
        // còn 1 bug là khi chọn mặc định không hiển thị lại
        if ($request->department_filter == "") {

            $searchst = $request->status_filter;

            $resultst = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->select('users.*', 'departments.name')
                ->where('users.status', '=', "$searchst")->paginate(7);

            $body = User::UserBuild($resultst);
            return response()->json(['body' => $body]);
        } else if ($request->status_filter == "") {

            $searchdp = $request->department_filter;
            $resultdp = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->select('users.*', 'departments.name')
                ->where('users.department_id', '=', "$searchdp")->paginate(7);
            $body = User::UserBuild($resultdp);
            return response()->json(['body' => $body]);
        } else if ($request->status_filter == "" | $request->department_filter == "") {

            $nhansu2 = User::paginate(7);
            $body = User::UserBuild($nhansu2);
            return response()->json(['body' => $body]);
        } else {
            $searchst1 = $request->status_filter;
            $searchdp1 = $request->department_filter;
            $resultall = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->select('users.*', 'departments.name')
                ->where('users.department_id', '=', "$searchdp1")
                ->where('users.status', '=', "$searchst1")->paginate(7);
            $body = User::UserBuild($resultall);
            return response()->json(['body' => $body]);
        }
    }

    public function nominees(Request $request)
    {
        $id = $request->id;
        $result = nominee::where('position_id', '=', "$id")->get();

        $body = nominee::nomineeBuild($result);
        return response()->json(['body' => $body]);
    }

    public function editLevel(Request $request)
    {
        $user = User::find($request->id);
        $user->level = $request->level;
        $user->save();
        return response()->json(['status' => 'succes', 'message' => 'Thay đổi đã được áp dụng !']);
    }

    /**
     * Store a newly created resourcestatus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|max:255|min:2',
            'phone' => 'required|min:6',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'address' => 'required',

        ], [
            'email.unique' => 'Email đã tồn tại !',
            'email.max' => 'Email quá dài !',
            'email.email' => 'Email không đúng định dạng !',
            'email.required' => 'Vui lòng nhập email !',
            'address.required' => 'Vui lòng nhập địa chỉ !',
            'phone.required' => 'Vui lòng nhập số điện thoại !',
            'phone.min' => 'Vui lòng nhập lại số điện thoại !',
            'fullname.required' => 'Vui lòng nhập họ tên !',
            'fullname.min' => 'Vui lòng nhập trên 2 ký tự !',
            'fullname.max' => 'Ký tự quá dài !',
            'password.min' => 'Mật khẩu phải lớn hơn 5 ký tự !',
            'password.required' => 'Vui lòng nhập mật khẩu !',

        ]);
        $user = new User();
        $max = User::orderBy('id', 'DESC')->first();
        $user->personnel_code = 'SCN' . $max->id + 1;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->address = $request->address;

        $user->save();

        $nhansu2 = User::leftjoin('departments', 'users.department_id', 'departments.id')
            ->select('users.*', 'departments.name')->paginate(7);
        $body = User::UserBuild($nhansu2);
        return response()->json(['status' => 'succes', 'body' => $body]);
    }
}
