@extends('auth.department.index')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <form id="vip">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">Thêm Nhân Viên Vào <span
                                        class="text-bolder"></span></p>
                                <div>
                                    <button class="btn btn-primary btn-sm ms-auto save me-2 add_staff">
                                        Thêm Chức Vụ
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" id="user_search" type="text">
                                        <input type="text" name="department_id" hidden>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <table class="table align-center align-middle">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Tên</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Ảnh</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Chức Vụ</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Chức Danh</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Số Điện Thoại</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Giới Tính</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
