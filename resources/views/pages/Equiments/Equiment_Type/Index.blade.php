@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Loại thiết bị'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <form id="form-equiment-type">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Thêm loại thiết bị</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto"><i
                                        class="fa-sharp fa-solid fa-floppy-disk"></i></button>
                                <button type="button" id="btnHuy" class="btn btn-secondary btn-sm mx-1"><i
                                        class="fa-sharp fa-solid fa-x"></i></button>
                            </div>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="example-text-input" class="form-control-label">Tên loại</label>
                                            <label id="error-name" class="form-control-label text-danger"></label>
                                        </div>
                                        <input class="form-control" type="text" name="name">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Trạng thái</label>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                                checked name="status">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 mb-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Danh sách loại thiết bị</p>
                            <div class="d-flex">
                                <select class="form-control form-control-sm mx-1" id="list_status">
                                    <option value="">Tất cả</option>
                                    <option value="1">Sử dụng</option>
                                    <option value="0">Không còn sử dụng</option>
                                </select>
                                <input type="text" id="txtTimKiem" class="form-control form-control-sm"
                                    placeholder="Tìm kiếm...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            #
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Loại thiết bị
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày tạo
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Trạng thái
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            colspan="2">
                                            Thao tác
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="list-equiment-type">
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" aria-label="Previous" id="btnPrevious">
                                            <i class="fa fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <div id="pageLink" class="d-flex"></div>
                                    <li class="page-item">
                                        <a class="page-link" aria-label="Next" id="btnNext">
                                            <i class="fa fa-angle-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('javascript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('assets/js/equimentType.js') }}"></script>
@endsection
