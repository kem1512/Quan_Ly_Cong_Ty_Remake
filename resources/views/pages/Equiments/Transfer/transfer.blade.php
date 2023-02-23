@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Chuyển giao thiết bị'])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button id="btnSave" class="btn btn-primary btn-sm">Thực hiện bàn giao</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="d-flex justify-content-center">
                            <img id="imgBenChuyen" class="rounded-circle img-fluid"
                                style="width: 150px;height: 150px;display: none;">
                        </div>
                        <div>
                            <div>
                                <label>Bên bàn giao (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" id="txtNameChuyen" class="form-control"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button id="btnHuy" style="display: none;" class="btn btn-secondary mb-0" type="button"
                                    id="button-addon2">Hủy</button>
                                <button id="btnBenChuyen" class="btn btn-primary mb-0" type="button"
                                    id="button-addon2">Chọn</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm" id="divchuyen">
                        <div class="d-flex justify-content-center">
                            <img id="imgbennhan" class="rounded-circle img-fluid"
                                style="width: 150px;height: 150px;display: none;">
                        </div>
                        <div>
                            <div>
                                <label>Bên nhận bàn giao (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" id="txtBenNhan" class="form-control" aria-label="Recipient's username"
                                    aria-describedby="button-addon2">
                                <button id="btnHuyBenNhan" style="display: none;" class="btn btn-secondary mb-0"
                                    type="button" id="button-addon2">Hủy</button>
                                <button id="btnBenNhan" class="btn btn-primary mb-0" type="button"
                                    id="button-addon2">Chọn</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div>
                            <div>
                                <label>Người thực hiện (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="txtInfo" name="{{ $user->id }}"
                                    value="{{ $user->fullname }}" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div>
                            <div>
                                <label>Loại chuyển giao (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div>
                                <select id="changtype" class="form-control">
                                    <option value="hand-over">Bàn giao</option>
                                    <option value="recall">Thu hồi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div>
                            <label>Thiết bị bàn giao (<strong class="text-danger">*</strong>)</label>
                        </div>
                        <div>
                            <table class="table text-center align-items-center">
                                <thead class="table-primary">
                                    <tr>
                                        <td>#</td>
                                        <td>Ảnh</td>
                                        <td>Tên thiết bị</td>
                                        <td>Số lượng</td>
                                        <td>Thao tác</td>
                                    </tr>
                                </thead>
                                <tbody id="list-equiment-storehouse">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div>
                            <div>
                                <label>Chi tiết (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div>
                                <textarea id="txtchitiet" class="form-control" cols="85" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <select class="form-control form-control-sm me-2" id="storehouse_select">
                                    <option value="">Tất cả</option>
                                    @foreach ($storehouse as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <table class="table text-center align-items-center">
                                <thead class="table-primary">
                                    <tr>
                                        <td>#</td>
                                        <td>Ảnh thiết bị</td>
                                        <td>Tên thiết bị</td>
                                        <td>Số lượng</td>
                                        <td>Thao tác</td>
                                    </tr>
                                </thead>
                                <tbody id="list_storehouse">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body"></div>
        </div>
        @include('components.modal_chon_nhan_vien')
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('javascript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('assets/js/transfer.js') }}"></script>
@endsection
