@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Phân Quyền'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row" style="min-height: 79vh">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card mb-4">
                    <div class="card-header pb-0">

                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-2 row">
                        <div class="col-6">
                            <div class="text-center mb-5">
                                <h4>Chức Vụ</h4>
                            </div>
                            <div class="border border-success p-4 rounded-3 " style="min-height: 62vh">
                                <div class="d-flex justify-content-end w-100">
                                    <input id="id_autho" class="d-none" type="text">
                                    <a class="btn btn-success" id="btn_save_autho">Thêm Mới</a>
                                </div>
                                <label for="exampleFormControlInput1" class="col-4 col-form-label w-100">Vui lòng nhập tên
                                    nhóm quyền :</label>
                                <input type="text" name="autho_name"class="form-control" id="autho_name" />
                                <span class="text-danger text-xs pt-1 email_error"></span>
                                <div class="mt-4">
                                    <h5 class="text-center">Các Nhóm Quyền</h5>
                                </div>
                                <div id="list_autho_build">
                                    @foreach ($authos as $item)
                                        <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                            <a class="justify-content-start col-8 ">
                                                <i class="ni ni-fat-delete"></i>{{ $item->name_autho }}</a>
                                            <div class="col-4 d-flex justify-content-end">
                                                <a onclick="get_autho_By_Id({{ $item->id }});"
                                                    class="text-sm font-weight-bold mb-0 " id="btn_autho_update"
                                                    style="cursor: pointer">Sửa
                                                </a>
                                                | <a class="text-sm font-weight-bold mb-0 "
                                                    onclick="delete_autho_By_Id({{ $item->id }});" id="btn_autho_delete"
                                                    style="cursor: pointer">
                                                    Xóa</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mb-5">
                                <h4>Danh Sách Chức Năng</h4>
                            </div>
                            <div class="accordion border border-success p-4 rounded-3" id="accordionPanelsStayOpenExample"
                                style="min-height: 62vh">
                                <div class="accordion-item">
                                    <h2 class="accordion-header " id="panelsStayOpen-headingTwo">
                                        <button class="accordion-button collapsed fw-bold " type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            Nhân Sự
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingTwo">
                                        <div class="accordion-body">
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                                <a class="justify-content-start col-10 text-sm ">
                                                    <i class="ni ni-bold-right"></i>
                                                    Quyền Truy Cập</a>
                                                <input id="personnel_autho_access" class="col-1 checkbox_autho"
                                                    type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                                <a class="justify-content-start col-10 text-sm ">
                                                    <i class="ni ni-bold-right"></i>
                                                    Thêm Nhân Sự</a>
                                                <input id="insert_personnel" class="col-1 " type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex rounded">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Sửa Nhân Sự</a>
                                                <input id="update_personnel" class="col-1" type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    xóa Nhân Sự
                                                </a>
                                                <input id="delete_personnel" class="col-1" type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Duyệt CV </a>
                                                <input id="accept_cv_autho" class="col-1" type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Sửa CV</a>
                                                <input id="update_cv_autho" class="col-1" type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Xếp Lịch Phỏng Vấn</a>
                                                <input id="inter_cv_autho" class="col-1"s type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Đánh Giá Ứng Viên</a>
                                                <input id="eva_cv_autho" class="col-1"s type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Offer Cho Ứng Viên </a>
                                                <input id="offer_cv_autho" class="col-1"s type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                        <button class="accordion-button collapsed fw-bold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree"
                                            aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                            Phòng Ban
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Sửa</a>
                                                <input class="col-1 "s type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex rounded">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Thêm</a>
                                                <input class="col-1"s type="checkbox">
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Xóa</a>
                                                <input class="col-1"s type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
    </div>
@endsection
