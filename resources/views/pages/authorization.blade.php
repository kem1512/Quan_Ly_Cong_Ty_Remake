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
                                <label for="exampleFormControlInput1" class="col-4 col-form-label w-100">Vui lòng chọn chức
                                    vụ :</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Chức Vụ</option>
                                    @foreach ($positions as $item)
                                        <option value="{{ $item->id }}">{{ $item->position }}</option>
                                    @endforeach
                                </select>
                                <div class="mt-4">
                                    <h5 class="text-center">Quyền Truy Cập</h5>
                                </div>

                                <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                    <a class="justify-content-start col-10 ">
                                        <i class="ni ni-fat-delete"></i>
                                        Nhân Sự</a>
                                    <input class="col-1 "s type="checkbox" checked>
                                </div>
                                <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                    <a class="justify-content-start col-10 ">
                                        <i class="ni ni-fat-delete"></i>
                                        Phòng Ban</a>
                                    <input class="col-1 "s type="checkbox" checked>
                                </div>
                                <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                                    <a class="justify-content-start col-10 ">
                                        <i class="ni ni-fat-delete"></i>
                                        Thiết Bị</a>
                                    <input class="col-1 "s type="checkbox" checked>
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
                                                    Thêm Nhân Sự</a>
                                                <input class="col-1 "s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex rounded">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Sửa Nhân Sự</a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    xóa Nhân Sự
                                                </a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Duyệt CV </a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Sửa CV</a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Xếp Lịch Phỏng Vấn</a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Đánh Giá Ứng Viên</a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Offer Cho Ứng Viên </a>
                                                <input class="col-1"s type="checkbox" checked>
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
                                                <input class="col-1 "s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex rounded">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Thêm</a>
                                                <input class="col-1"s type="checkbox" checked>
                                            </div>
                                            <div class="w-100 row  p-2 mb-1 justify-content-between d-flex ">
                                                <a class="justify-content-start col-10 text-sm">
                                                    <i class="ni ni-bold-right"></i>
                                                    Xóa</a>
                                                <input class="col-1"s type="checkbox" checked>
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
