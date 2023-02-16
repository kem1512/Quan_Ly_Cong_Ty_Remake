@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

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
                                        class="text-bolder">{{ $department[0]->name }}</span></p>
                                <button class="btn btn-primary btn-sm ms-auto save me-2 add_staff">
                                    Lưu thông tin
                                </button>
                                <button class='btn btn-primary btn-sm clear'>Hủy</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" id="user_search" type="text">
                                        <input type="text" name="department_id" value="{{ $department[0]->id }}" hidden>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="container_staff">
                                        <table class="table align-center align-middle users_table">
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
                                                    Số Điện Thoại</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Giới Tính</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Thao Tác</th>
                                            </tr>
                                            @foreach ($department[0]->users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="fcustomCheck1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $user->fullname }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            <img src="{{ $user->img_url ?? 'https://cdn-icons-png.flaticon.com/512/147/147144.png' }}"
                                                                class="rounded-circle" style="width: 100px; height: 100px;" alt="">
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group m-0">
                                                            <select
                                                                class="form-control text-secondary text-xs font-weight-bold w-75 text-center"
                                                                id="exampleFormControlSelect1">
                                                                <option>Nhân Viên</option>
                                                                <option>Trưởng Phòng</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $user->phone }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $user->gender ? 'Nam' : 'Nữ' }}</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger staff m-0">Xóa</button>
                                                    </td>
                                                </tr>
                                            @endforeach
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
