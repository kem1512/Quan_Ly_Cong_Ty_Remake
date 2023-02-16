@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Nhân Sự'])

    @yield('personnel')

    <style>
        #adddropdown {
            top: -100%;
        }

        #btn-edit,
        #btn-del {
            cursor: pointer;
        }

        .text-muted {
            /* display: none; */
        }

        #adddropdown {
            top: -10%;
            -webkit-animation-name: rightanimationend;
            -webkit-animation-duration: 0.4s;
            animation-name: rightanimation;
            animation-duration: 0.4s;
        }

        #offcanvasNavbar {
            width: 40%;
        }

        .btn-close {
            color: #524f4c !important;
        }

        .swal2-cancel {
            margin-right: 10% !important;
        }

        #btn-submit-add {
            text-align: center;
        }

        #offcanvasNavbarut {
            width: 50%;
        }

        #offcanvasNavbarupdate {
            width: 70%;
        }

        @media only screen and (max-width: 1400px) {
            #offcanvasNavbarupdate {
                width: 78%;
            }

            #offcanvasNavbar {
                width: 78%;
            }
        }

        @media only screen and (max-width: 1200px) {
            #offcanvasNavbarupdate {
                width: 100%;
            }

            #offcanvasNavbar {
                width: 100%;
            }
        }

        @media only screen and (max-width: 1000px) {
            #imgupdate {
                width: 12rem;
                height: 17rem;
            }
        }

        #imgupdate {
            color: bisque;
            border: 1px solid #b3aea7;
            width: 18rem;
            height: 23rem;
            margin-left: 8%;
        }
    </style>
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <ul class="nav nav-tabs justify-content-around border-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true" style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">HRM</h5>
                                <span class="h2 font-weight-bold mb-0">{{ $ucount }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false"style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Ứng Tuyển</h5>
                                <span class="h2 font-weight-bold mb-0">350,897</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false"style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Xét Duyệt</h5>
                                <span class="h2 font-weight-bold mb-0">350,897</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- MAIN CONTENT  --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    {{-- =================================================================== tab HRM =================================================================== --}}
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class=" d-flex justify-content-between">
                                    <h6>Danh Sách Nhân Sự</h6>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Search..." id="search">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status_select" id="status_select">
                                            <option selected>Trạng Thái</option>
                                            <option value="0">Chưa Kích Hoạt</option>
                                            <option value="1">Đang Hoạt Động</option>
                                            <option value="2">Nghỉ Phép</option>
                                            <option value="3">Khoá</option>
                                            <option value="4">Nghỉ việc</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status_select" id="department_select">
                                            <option selected>Phòng ban</option>
                                            @foreach ($phongbans as $pb)
                                                <option value="{{ $pb->id }}">{{ $pb->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <a id="form-add" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasNavbar">Thêm</a>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2" id="body_query">
                                {!! \App\Models\User::UserBuild($nhansu) !!}

                            </div>
                        </div>
                    </div>
                    {{-- =================================================================== Tab HRM =================================================================== --}}




                    {{-- =================================================================== Tab Ứng tuyển =================================================================== --}}
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class=" d-flex justify-content-between">
                                    <h6>Hồ Sơ Ứng Tuyển</h6>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Search..." id="search">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status_select" id="status_select">
                                            <option selected>Trạng Thái</option>
                                            <option value="0">Chưa Kích Hoạt</option>
                                            <option value="1">Đang Hoạt Động</option>
                                        </select>
                                    </div>
                                    <a id="form-add" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasNavbarut">Thêm Hồ Sơ</a>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2" id="body_query">
                                {!! \App\Models\User::UserBuild($nhansu) !!}

                            </div>
                        </div>
                    </div>
                    {{-- =================================================================== Tab Ứng tuyển =================================================================== --}}

                    {{-- =================================================================== Tab Xét Duyệt =================================================================== --}}
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">contact
                    </div>
                    {{-- =================================================================== Tab Xét Duyệt =================================================================== --}}
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    {{-- tab HRM --}}

    <!-- ADD HRM dropdow  -->
    <div id="adddropdown" class="bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                            class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="offcanvas-body">
                    <h1 id="add-title" style="text-align: center">Thêm Nhân Sự</h1>
                    <form class="mt-8" method="POST" id="insert_personnel">
                        @csrf
                        <div class="mb-3 row ml-7">
                            <label for="fullname" class="col-sm-4 col-form-label">Tên Nhân Sự</label>
                            <div class="col-sm-6">
                                <input type="text" name="fullname" id="fullname" class="form-control"
                                    id="fullname" placeholder="(vd : Nguyễn Văn A)" />
                                <span class="text-danger text-xs pt-1 fullname_error"></span>
                            </div>
                        </div>

                        <div class="mb-3 row ml-7">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="email" class="form-control"
                                    id="staticEmail" placeholder="email@example.com" />
                                <span class="text-danger text-xs pt-1 email_error"></span>
                            </div>
                        </div>

                        <div class="mb-3 row ml-7">
                            <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" id="password" class="form-control"
                                    id="inputPassword" />
                                <span class="text-danger text-xs pt-1 password_error"></span>
                            </div>
                        </div>

                        <div class="mb-3 row ml-7">
                            <label for="phoneadd" class="col-sm-4 col-form-label">Số Điện Thoại</label>
                            <div class="col-sm-6">
                                <input type="text" name="phone" id="phone" class="form-control" id="phoneadd"
                                    placeholder="(vd : 0123456789)" />
                                <span class="text-danger text-xs pt-1 phone_error"></span>
                            </div>
                        </div>
                        <div class="mb-3 row ml-7">
                            <label for="mansadd" class="col-sm-4 col-form-label">Địa Chỉ</label>
                            <div class="col-sm-6">
                                <input type="text" name="personnel_code" id="address" class="form-control"
                                    placeholder="(vd : SCN0001)" />
                                <span class="text-danger text-xs pt-1 address_error"></span>
                            </div>
                        </div>
                        <div id="btn-submit-add">
                            <button type="submit" id="btn_insert_personnel" class="btn btn-primary mt-7">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update HRM page -->
    <div id="updatedropdown" class="bg-light fixed-top">
        <div class="container-fluid">
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarupdate"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <h1 id="add-title" style="text-align: center">Sửa Nhân Sự</h1>
                    <form class="mt-5 col col-12" id="form_update" action="{{ route('update.user') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row wraper">
                            <div class="row">
                                <div class="col-4 justify-content-center" style="text-align: center">
                                    <div id="imgupdate">
                                        <img id="img_url" src="" width="100%" height="100%"
                                            alt="ảnh Nhân sự" />
                                    </div>
                                    <div class="m-3 col-9">
                                        <input type="file" name="img_url" onchange="readURL(this);"
                                            class="form-control" id="img_url_update">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-update d-none">
                                        <label for="mans" class="col-sm-4 col-form-label d-none">id :</label>
                                        <input type="text" readonly name="id" class="form-control d-none"
                                            id="id_user" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="mans" class="col-sm-4 col-form-label">Mã Nhân Sự :</label>
                                        <input type="text" readonly id="personnel_codeu" class="form-control"
                                            id="mans" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="name" class="col-sm-4 col-form-label">Họ Tên :</label>
                                        <input type="text" name="fullname" id="fullnameu" class="form-control"
                                            id="name" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="Email" class="col-sm-4 col-form-label">Email :</label>
                                        <input type="email" name="email" id="emailu" class="form-control"
                                            id="Email" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="phone" class="col-sm-4 col-form-label">Số Điện
                                            Thoại:</label>
                                        <input type="text" name="phone" id="phoneu" class="form-control"
                                            id="phone" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="phone" class="col-sm-4 col-form-label">Quê Quán:</label>
                                        <input type="text" name="address" id="addressup" class="form-control"
                                            id="phone" required />
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label for="phongban" class="col-sm-4 col-form-label">Phòng Ban :</label>
                                    <select class="form-control" name="department_id" id="department_idu">
                                        @foreach ($phongbans as $pb)
                                            <option value="{{ $pb->id }}">{{ $pb->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="chucvu" class="col-sm-4 col-form-label">Chức Vụ :</label>
                                    <select class="form-control" name="position_id" id="position_idu">
                                        @foreach ($postions as $po)
                                            <option value="{{ $po->id }}">{{ $po->position }}</option>
                                        @endforeach
                                    </select>
                                    <label for="chucvu" class="col-sm-4 col-form-label">Chức Danh :</label>
                                    <select class="form-control" name="status" id="nominee_bild">
                                    </select>
                                    <label for="trangthai" class="col-sm-4 col-form-label">Trạng Thái :</label>
                                    <select class="form-control" name="status" id="statusu">
                                        <option value="0">Chưa Kích Hoạt</option>
                                        <option value="1">Đang Hoạt Động</option>
                                        <option value="2">Nghỉ Phép</option>
                                        <option value="3">Khoá</option>
                                        <option value="4">Nghỉ việc</option>
                                    </select>
                                    <label for="trangthai" class="col-sm-4 col-form-label">Giới Tính :</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="0">Không được quy định</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-update">
                                    <label for="dateofbirth" class="col-sm-4 col-form-label">Ngày Sinh:</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        id="date_of_birthu" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-update">
                                    <label for="recrui" class="col-sm-4 col-form-label">Ngày Tuyển Dụng:</label>
                                    <input type="date" name="recruitment_date" class="form-control"
                                        id="recruitment_dateu" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="exampleFormControlTextarea1" id="about-text" class="col-sm-4 col-form-label">
                                    Giới
                                    Thiệu Về bản
                                    Thân
                                    :</label>
                                <textarea class="form-control" name="about" id="about" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="btn-group-update mt-5 align-items-center justify-content-center">
                            <button class="btn btn-primary" id="btn_update_personnel">Cập Nhật</button>
                            <a data-bs-dismiss="offcanvas" aria-label="Close" class="btn btn-danger">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD Ứng Tuyển dropdow  -->
    <div id="adddropdown" class="bg-light fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarut"
                aria-controls="offcanvasNavbarut">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarut"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                            class="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div class="offcanvas-body">
                    <h1 id="add-title" style="text-align: center">Thêm Hồ Sơ Ứng Tuyển</h1>
                    <form class="mt-5" method="POST" id="insert_ut">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên Ứng Viên</label>
                                    <input class="form-control dbcl_ctl" id="name_ut" type="text" name="name_ut"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email</label>
                                    <input class="form-control" id="email_ut" name="email_ut" type="text"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Số Điện Thoại</label>
                                    <input class="form-control " type="text" id="phone_ut" name="phone_ut"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ngày Sinh</label>
                                    <input class="form-control " type="date" name="date_of_birth_ut"
                                        id="date_of_birth_ut" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Giới Tính</label>
                                    <select class="form-control " name="gender" id="gender_ut">
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">CV</label>
                                    <input class="form-control" type="file" name="cv_ut" id="cv_ut"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Chức Vụ</label>
                                    <select class="form-control" name="position_ut" id="position_ut">
                                        @foreach ($postions as $po)
                                            <option value="{{ $po->id }}">{{ $po->position }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Vị Trí Ứng Truyển</label>
                                    <select class="form-control" name="nominees_ut" id="nominees_ut">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="exampleFormControlTextarea1" id="about-text" class="col-sm-4 col-form-label">
                                    Địa Chỉ :</label>
                                <textarea class="form-control" name="about" id="about" rows="3"></textarea>
                            </div>
                        </div>
                        <div id="btn-submit-add">
                            <button type="submit" id="btn_insert_ut" class="btn btn-primary mt-7">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Ứng Tuyển page -->
    <div id="updatedropdown" class="bg-light fixed-top">
        <div class="container-fluid">
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarupdate"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <h1 id="add-title" style="text-align: center">Sửa Nhân Sự</h1>
                    <form class="mt-5 col col-12" id="form_update" action="{{ route('update.user') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row wraper">
                            <div class="row">
                                <div class="col-4 justify-content-center" style="text-align: center">
                                    <div id="imgupdate">
                                        <img id="img_url" src="" width="100%" height="100%"
                                            alt="ảnh Nhân sự" />
                                    </div>
                                    <div class="m-3 col-9">
                                        <input type="file" name="img_url" onchange="readURL(this);"
                                            class="form-control" id="img_url_update">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-update d-none">
                                        <label for="mans" class="col-sm-4 col-form-label d-none">id :</label>
                                        <input type="text" readonly name="id" class="form-control d-none"
                                            id="id_user" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="mans" class="col-sm-4 col-form-label">Mã Nhân Sự :</label>
                                        <input type="text" readonly id="personnel_codeu" class="form-control"
                                            id="mans" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="name" class="col-sm-4 col-form-label">Họ Tên :</label>
                                        <input type="text" name="fullname" id="fullnameu" class="form-control"
                                            id="name" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="Email" class="col-sm-4 col-form-label">Email :</label>
                                        <input type="email" name="email" id="emailu" class="form-control"
                                            id="Email" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="phone" class="col-sm-4 col-form-label">Số Điện
                                            Thoại:</label>
                                        <input type="text" name="phone" id="phoneu" class="form-control"
                                            id="phone" required />
                                    </div>
                                    <div class="form-update">
                                        <label for="phone" class="col-sm-4 col-form-label">Quê Quán:</label>
                                        <input type="text" name="address" id="addressup" class="form-control"
                                            id="phone" required />
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label for="phongban" class="col-sm-4 col-form-label">Phòng Ban :</label>
                                    <select class="form-control" name="department_id" id="department_idu">
                                        @foreach ($phongbans as $pb)
                                            <option value="{{ $pb->id }}">{{ $pb->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="chucvu" class="col-sm-4 col-form-label">Chức Vụ :</label>
                                    <select class="form-control" name="position_id" id="position_idu">
                                        @foreach ($postions as $po)
                                            <option value="{{ $po->id }}">{{ $po->position }}</option>
                                        @endforeach
                                    </select>
                                    <label for="chucvu" class="col-sm-4 col-form-label">Chức Danh :</label>
                                    <input type="text" name="title" class="form-control" id="title" required />
                                    <label for="trangthai" class="col-sm-4 col-form-label">Trạng Thái :</label>
                                    <select class="form-control" name="status" id="statusu">
                                        <option value="0">Chưa Kích Hoạt</option>
                                        <option value="1">Đang Hoạt Động</option>
                                        <option value="2">Nghỉ Phép</option>
                                        <option value="3">Khoá</option>
                                        <option value="4">Nghỉ việc</option>
                                    </select>
                                    <label for="trangthai" class="col-sm-4 col-form-label">Giới Tính :</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="0">Không được quy định</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-update">
                                    <label for="dateofbirth" class="col-sm-4 col-form-label">Ngày Sinh:</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        id="date_of_birthu" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-update">
                                    <label for="recrui" class="col-sm-4 col-form-label">Ngày Tuyển Dụng:</label>
                                    <input type="date" name="recruitment_date" class="form-control"
                                        id="recruitment_dateu" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="exampleFormControlTextarea1" id="about-text" class="col-sm-4 col-form-label">
                                    Giới
                                    Thiệu Về bản
                                    Thân
                                    :</label>
                                <textarea class="form-control" name="about" id="about" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="btn-group-update mt-5 align-items-center justify-content-center">
                            <button class="btn btn-primary" id="btn_update_personnel">Cập Nhật</button>
                            <a data-bs-dismiss="offcanvas" aria-label="Close" class="btn btn-danger">Close</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
