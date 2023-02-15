@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Thiết bị'])
    <div class="container-fluid py-4">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header">
                    <div class="align-items-center">
                        <div class="row mx-4">
                            <div class="col-sm d-flex mx-5 justify-content-between">
                                <div>
                                    <button id="btnThem" class="btn bg-gradient-primary btn-sm btn-block mx-1"><i
                                            class="fa-solid fa-plus"></i></button>
                                    <button id="btnThemExcel" class="btn bg-gradient-primary btn-sm btn-block mx-1"><i
                                            class="fa-solid fa-table"></i></button>
                                </div>

                                <div class="d-flex row">
                                    <div class="me-1 col-sm">
                                        <select class="form-control form-control-sm" style="width: 150px;">
                                            <option value="">Trạng thái</option>
                                        </select>
                                    </div>

                                    <div class="me-1 col-sm">
                                        <select class="form-control form-control-sm" style="width: 150px;">
                                            <option value="">Phòng</option>
                                        </select>
                                    </div>

                                    <div class="col-sm">
                                        <input type="text" id="txtSearch" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm..." style="width: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body text-center">
                    <div class="table-responsive p-0">
                        <table class="table table-bordered table-hover align-items-center">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Loại thiết bị
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ảnh
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tên thiết bị
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Trạng thái
                                    </th>
                                    <th colspan="2"
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="list-equiment">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div id="paginate">
                            <div class="mt-5 d-flex justify-content-center">
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
                @include('layouts.footers.auth.footer')
            </div>

            <!-- Modal Thêm thiết bị -->
            <div class="modal fade" id="modalThem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm mới thiết bị</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="form-equiment">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xl col-md col-sm">
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <label>Tên thiết bị (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger" id="name-error"></label>
                                            </div>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Ảnh thiết bị (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger" id="image-error"></label>
                                            </div>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Thông số thiết bị (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger"
                                                    id="specifications-error"></label>
                                            </div>
                                            <textarea class="form-control" name="specifications" cols="50" rows="3"></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Nhà cung cấp (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger"
                                                    id="manufacture-error"></label>
                                            </div>
                                            <input type="text" name="manufacture" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Giá nhập (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger" id="price-error"></label>
                                            </div>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Ngày hết hạn (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger" id="out-date-error"></label>
                                            </div>
                                            <input type="date" name="out_of_date" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Hạn bảo hành (<strong class="text-danger">*</strong>)</label>
                                                <label class="form-control-label text-danger" id="price-error"></label>
                                            </div>
                                            <input type="date" name="warranty_date" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Loại sản phẩm (<strong class="text-danger">*</strong>)</label>
                                            </div>
                                            <select name="equiment_type_id" class="form-control">
                                                @foreach ($list_loai as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between">
                                                <label>Trạng thái (<strong class="text-danger">*</strong>)</label>
                                            </div>
                                            <div class="form-check form-switch mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    id="flexSwitchCheckDefault" checked name="status">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="btnHuy"><i
                                        class="fa-solid fa-x"></i></button>
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa-solid fa-floppy-disk"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal import excel -->
            <div class="modal fade" id="modalExcel" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nhập file excel</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="equiment/importexcel" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection

        @section('javascript')
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="module" src="{{ asset('assets/js/equiment.js') }}"></script>
        @endsection
