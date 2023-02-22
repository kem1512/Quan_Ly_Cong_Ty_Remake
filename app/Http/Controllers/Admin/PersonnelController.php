<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddInterviewRequest;
use App\Http\Requests\saveCV;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\updateCVRequest;
use App\Http\Requests\updateUserRequest;
use App\Mail\PersonnelAcceptMailer;
use App\Mail\PersonnelMailer;
use App\Models\CurriculumVitae;
use App\Models\Department;
use App\Models\interview;
use App\Models\nominee;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\PseudoTypes\IntegerRange;

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

        if ($rq->ajax()) {
            $data = User::getAll();
            $body = User::UserBuild($data);
            return response()->json(['body' => $body]);
        };

        //lấy số lượng nhân sự có trong db
        $ucount = User::all()->count();
        $cvcount = CurriculumVitae::where('status', '=', 0)->orWhere('status', '=', 1)->orWhere('status', '=', 2)->count();
        // lấy tất cả phòng ban
        $phongbans = Department::all();
        //lấy tất cả chức vụ
        $postions = Position::all();
        //build table CV
        $cvs = CurriculumVitae::get_All_CV_UT();
        $cvut = CurriculumVitae::UTBuild($cvs);
        //join chỉ lấy phần chung | leftjoin lấy cả chung và riêng
        $nhansu = User::getAll();
        return view('pages.personnel.personnel', compact('phongbans', 'postions', 'nhansu', 'cvcount', 'cvs', 'ucount',));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //====================PERSONNEL====================================
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
    public function update(updateUserRequest $request)
    {
        // check quyền user đăng nhập
        $user = User::findOrFail($request->id);
        $level = Auth::user()->level;
        if ($level == 0) {
            return response()->json(['status' => 'error', 'message' => 'Không thể sửa do không đủ quyền !']);
        }

        //check tuổi
        $age = floor((time() - strtotime($request->date_of_birth)) / 31556926);
        if ($age < 15) {
            return response()->json(['status' => 'error', 'message' => 'Tuổi của nhân sự phải lớn hơn 15 !']);
        }
        //check email
        if ($user->email !== $request->email) {
            $request->validate([
                'email' => 'unique:users,email'
            ], [
                'email.unique' => 'Email đã tồn tại !'
            ]);
        }

        if (!$request->img_url == '') {
            $fileName = time() . '.' . $request->img_url->extension();
            $request->img_url->move(public_path('img'), $fileName);
            $user->img_url = $fileName;
        }

        $user->gender = $request->gender;
        $user->about = $request->about;
        $user->nominee_id = $request->nominee_bild;
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
        $nhansu2 = User::getAll();
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
            $nhansu2 = User::getAll();
            $body = User::UserBuild($nhansu2);
            return response()->json(['body' => $body]);
        }
    }


    public function search(Request $request)
    {
        //search by personnel_code , fullname and email
        $search = $request->search;
        if ($search == '') {
            $result = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
                ->select('users.*', 'nominees.nominees', 'departments.name')
                ->paginate(7);
            $body = User::UserBuild($result);
            return response()->json(['body' => $body]);
        } else {
            $result = User::where('personnel_code', 'like', "%$search%")
                ->orWhere('fullname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->leftjoin('departments', 'users.department_id', 'departments.id')
                ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
                ->select('users.*', 'nominees.nominees', 'departments.name')
                ->paginate(7);
            $body = User::UserBuild($result);
            return response()->json(['body' => $body]);
        }
    }
    public function Add_interview(AddInterviewRequest $request)
    {
        //check quyền
        $level1 = Auth::user()->level;
        if ($request->interviewer1 == $request->interviewer2) {
            return response()->json(['status' => 'error', 'message' => '2 người phỏng vấn phải khác nhau !']);
        }
        if ($level1 == 0) {
            return response()->json(['status' => 'error', 'message' => 'Không thể xóa do không đủ quyền !']);
        }
        $daterq = $request->interview_date;
        $now = Carbon::now();
        if ($daterq <= $now) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng chọn lịch phỏng vấn phù hợp !']);
        }
        $cv = CurriculumVitae::find($request->id_cv);
        if (!empty($cv->interview_id)) {
            return response()->json(['status' => 'error', 'message' => 'Ứng viên này đã được xếp lịch !']);
        }
        if ($cv->status !== 2) {
            return response()->json(['status' => 'error', 'message' => 'Ứng viên này không thể xếp lịch !']);
        }
        $interview = new interview();
        $interview->interviewer1 = $request->interviewer1;
        $interview->interviewer2 = $request->interviewer2;
        $interview->interview_date = $request->interview_date;
        $interview->interview_time = $request->interview_time;
        $interview->cate_inter = $request->cate_inter;
        $interview->location = $request->location;
        $interview->status = 1;
        $interview->save();
        $id_inter = interview::select('id')->orderBy('id', 'DESC')->first()->id;
        $cv->interview_id = $id_inter;
        $cv->status = 3;
        $cv->save();
        Mail::to('lutl@s-connect.net')->send(new PersonnelAcceptMailer($cv->id, $id_inter));
        return response()->json(['status' => 'success', 'message' => 'Xếp Lịch Thành Công !']);
    }
    public function search_interviewer(Request $request)
    {
        $search = $request->search;

        if (!empty($search)) {
            $result = User::where('personnel_code', 'like', "%$search%")
                ->orWhere('fullname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->limit(5)->get();
        }

        $response = array();
        foreach ($result as $result) {
            $response[] = array("value" => $result->id, "label" => $result->fullname);
        }

        return response()->json($response);
    }

    public function fillter(Request $request)
    {
        // còn 1 bug là khi chọn mặc định không hiển thị lại
        if ($request->department_filter == "") {

            $searchst = $request->status_filter;

            $resultst = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
                ->select('users.*', 'nominees.nominees', 'departments.name')
                ->where('users.status', '=', "$searchst")->paginate(7);

            $body = User::UserBuild($resultst);
            return response()->json(['body' => $body]);
        } else if ($request->status_filter == "") {

            $searchdp = $request->department_filter;
            $resultdp = User::leftjoin('departments', 'users.department_id', 'departments.id')
                ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
                ->select('users.*', 'nominees.nominees', 'departments.name')
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
                ->leftjoin('nominees', 'users.nominee_id', 'nominees.id')
                ->select('users.*', 'nominees.nominees', 'departments.name')
                ->where('users.department_id', '=', "$searchdp1")
                ->where('users.status', '=', "$searchst1")->paginate(7);
            $body = User::UserBuild($resultall);
            return response()->json(['body' => $body]);
        }
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
    public function store(StorePostRequest $request)
    {
        $user = new User();
        $max = User::orderBy('id', 'DESC')->first();
        $user->personnel_code = 'SCN' . $max->id + 1;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->address = $request->address;

        $user->save();

        $nhansu2 = User::getAll();
        $body = User::UserBuild($nhansu2);
        return response()->json(['status' => 'succes', 'body' => $body]);
    }
    //====================CV====================================

    public function fillter_cv(Request $request)
    {
        if ($request->status == 9) {
            $resultst = CurriculumVitae::paginate(12);
            $body = CurriculumVitae::UTBuild($resultst);
            return response()->json(['status' => 'succes', 'cvbody' => $body]);
        } else {
            $search = $request->status;
            $resultall = CurriculumVitae::leftjoin('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
                ->select('curriculum_vitaes.*', 'nominees.nominees')
                ->where('status', '=', "$search")->paginate(12);
            $body = CurriculumVitae::UTBuild($resultall);
            return response()->json(['status' => 'succes', 'cvbody' => $body]);
        }
    }
    //search cv
    public function search_cv(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            //search by fullname and email
            $result = CurriculumVitae::leftjoin('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
                ->select('curriculum_vitaes.*', 'nominees.nominees')
                ->paginate(12);
            $body = CurriculumVitae::UTBuild($result);
            return response()->json(['status' => 'succes', 'cvbody' => $body]);
        } else {
            //search by fullname and email
            $result = CurriculumVitae::where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->leftjoin('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
                ->select('curriculum_vitaes.*', 'nominees.nominees')
                ->paginate(12);
            $body = CurriculumVitae::UTBuild($result);
            return response()->json(['status' => 'succes', 'cvbody' => $body]);
        }
    }
    public function getCVbyID(Request $request)
    {
        $cv = CurriculumVitae::join('nominees', 'curriculum_vitaes.nominee', 'nominees.id')
            ->join('positions', 'curriculum_vitaes.position_id', 'positions.id')
            ->select('curriculum_vitaes.*', 'nominees.nominees', 'positions.position')->where('curriculum_vitaes.id', '=', "$request->id")->get();
        // dd($cv);
        return response()->json(['status' => 'succes', 'body' => $cv]);
    }
    public function get_cv_update(Request $request)
    {
        $cv = CurriculumVitae::find($request->id);
        return response()->json(['status' => 'success', 'body' => $cv]);
    }
    public function update_cv(Request $request)
    {
        // dd($request);
    }
    public function update_status_cv(Request $request)
    {
        //check quyền
        $level = Auth::user()->level;
        if ($level == 0) {
            return response()->json(['status' => 'error', 'message' => 'Không thể thực hiện thao tác do không đủ quyền !']);
        }

        $cv = CurriculumVitae::find($request->id);
        // dd($request);
        if ($cv->status == 1) {
            return response()->json(['status' => 'error', 'message' => 'CV đã bị từ chối trước đó !']);
        } else if ($cv->status == 2) {
            return response()->json(['status' => 'error', 'message' => 'CV đã được duyệt trước đó !']);
        }



        // dd($request->status);
        if ($request->status == 1) {
            $cv->note = $request->note;
            $request->validate(
                [
                    'note' => 'required|min:5|max:1000'
                ],
                [
                    'note.required' => 'Để từ chối cv này, bạn vui lòng nhập lý do !',
                    'note.min' => 'Lý do quá ngắn !',
                    'note.max' => 'Lý do quá dài !',
                ]
            );
        }

        $cv->status = $request->status;
        if ($cv->status == 1) {
            $message = 'CV đã được từ chối !';
        } else if ($cv->status == 2) {
            $message = 'CV đã duyệt thành công !';
        }
        $cv->save();
        $id = $cv->id;
        if ($cv->status == 1) {
            Mail::to('lutl@s-connect.net')->send(new PersonnelMailer($id));
        }

        return
            response()->json(['status' => 'succes', 'message' => $message]);
    }
    public function getAllCVT()
    {
        $cvs = CurriculumVitae::get_All_CV_UT();
        $cvut = CurriculumVitae::UTBuild($cvs);
        return response()->json(['status' => 'succes', 'cvbody' => $cvut]);
    }
    public function saveCV(saveCV $request)
    {
        $cv = new CurriculumVitae();

        $fileName = 'CV' . time() . '.' . $request->cv_ut->extension();
        $request->cv_ut->move(public_path('cv'), $fileName);
        $cv->url_cv = $fileName;
        $cv->name = $request->name_ut;
        $cv->email = $request->email_ut;
        $cv->date_of_birth = $request->date_of_birth_ut;
        $cv->phone = $request->phone_ut;
        $cv->gender = $request->gender;
        $cv->position_id = $request->position_ut;
        $cv->nominee = $request->nominees_ut;
        $cv->about = $request->about_cv;
        $cv->save();
        $cvs = CurriculumVitae::get_All_CV_UT();
        $cvut = CurriculumVitae::UTBuild($cvs);
        return response()->json(['status' => 'succes', 'cvbody' => $cvut]);
    }
    //====================nominees====================================
    public function nominees(Request $request)
    {
        $id = $request->id;
        $result = nominee::where('position_id', '=', "$id")->get();
        // dd($result);
        $body = nominee::nomineeBuild($result);
        return response()->json(['body' => $body]);
    }
    public function nominees_first(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $result = nominee::where('position_id', '=', "$user->position_id")->get();
        // dd($result);
        $body = nominee::nomineeBuild($result);
        return response()->json(['body' => $body]);
    }
    public function nominees_cv(Request $request)
    {
        $id = $request->id;
        $cver = CurriculumVitae::find($id);
        $result = nominee::where('position_id', '=', "$cver->position_id")->get();
        $body = nominee::nomineeBuild($result);
        return response()->json(['body' => $body]);
    }

    public function update_cv_all(updateCVRequest $request)
    {
        $cv = CurriculumVitae::find($request->id_ut_update);
        if ($request->email_ut_update !== $cv->email) {
            $request->validate(
                [
                    'email_ut_update' => 'unique:curriculum_vitaes,email',
                ],
                [
                    'email_ut_update.unique' => 'Email đã tồn tại !',
                ]
            );
        };
        $fileName = 'CV' . time() . '.' . $request->cv_ut_update->extension();
        $request->cv_ut_update->move(public_path('cv'), $fileName);
        $cv->url_cv = $fileName;
        $cv->name = $request->name_ut_update;
        $cv->email = $request->email_ut_update;
        $cv->date_of_birth = $request->date_of_birth_ut_update;
        $cv->phone = $request->phone_ut_update;
        $cv->gender = $request->gender_ut_update;
        $cv->position_id = $request->position_ut_update;
        $cv->nominee = $request->nominees_ut_update;
        $cv->about = $request->about_ut_update;
        $cv->save();
        $cvs = CurriculumVitae::get_All_CV_UT();
        $cvut = CurriculumVitae::UTBuild($cvs);
        return response()->json(['status' => 'succes', 'cvbody' => $cvut]);
    }
}
