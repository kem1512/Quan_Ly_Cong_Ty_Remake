@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Chuyển giao thiết bị'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="d-flex justify-content-center">
                            <img src="https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg"
                                class="rounded-circle img-fluid w-25">
                        </div>
                        <div>
                            <div>
                                <label>Bên bàn giao (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Recipient's username"
                                    aria-describedby="button-addon2">
                                <button id="btnBenChuyen" class="btn btn-primary mb-0" type="button"
                                    id="button-addon2">Chọn</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm" id="divchuyen">
                        <div class="d-flex justify-content-center">
                            <img src="https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg"
                                class="rounded-circle img-fluid w-25">
                        </div>
                        <div>
                            <div>
                                <label>Bên nhận bàn giao (<strong class="text-danger">*</strong>)</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="Recipient's username"
                                    aria-describedby="button-addon2">
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
                                <label>Loại chuyển giao</label>
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
                <div class="row mt-4">
                    <div class="d-flex mb-2">
                        <select class="form-control" id="storehouse_select">
                            @foreach ($storehouse as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control" id="txttimkiem">
                    </div>
                    <div>
                        <table class="table text-center">
                            <thead>
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
