@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kho'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <div class="justify-content-between align-items-center">
                    <div class="row mx-4">
                        <div class="col-sm d-flex mx-5">
                            <div>
                                <button id="btnThem" class="btn bg-gradient-primary btn-sm btn-block mx-1"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                            <div>
                                <input type="text" id="txtSearch" class="form-control form-control-sm w-100"
                                    placeholder="Tìm kiếm...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div id="table-warehouse" class="row justify-content-center">

                </div>
            </div>
            <div class="card-footer">
                <div id="paginate">
                    <div class="mt-5 d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" aria-label="Previous" id="btnPrevious" style="cursor: pointer;">
                                        <i class="fa fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <div id="pageLink" class="d-flex"></div>
                                <li class="page-item">
                                    <a class="page-link" aria-label="Next" id="btnNext" style="cursor: pointer;">
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
    @include('components.detail_warehouse_modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModalSignUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h3 class="font-weight-bolder text-primary text-gradient" id="title"></h3>
                        </div>
                        <div class="card-body pb-3">
                            <div class="d-flex justify-content-center">
                                <img id="image-kho" class="img-fluid border border-primary"
                                    style="width: 200px;height: 200px;">
                            </div>
                            <div>
                                <form id="formKho" role="form text-left">
                                    <div class="d-flex justify-content-between">
                                        <label>Tên kho (<strong class="text-danger">*</strong>)</label>
                                        <label id="error-name" class="form-control-label text-danger"></label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <label>Địa chỉ (<strong class="text-danger">*</strong>)</label>
                                        <label id="error-address" class="form-control-label text-danger"></label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <label>Ảnh (<strong class="text-danger">*</strong>)</label>
                                        <label id="error-image" class="form-control-label text-danger"></label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input id="image" type="file" name="image" class="form-control">
                                    </div>
                                    <label>Trạng thái (<strong class="text-danger">*</strong>)</label>
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" checked
                                            name="status">
                                    </div>
                                    <div class="text-center">
                                        <div class="d-flex">
                                            <button type="submit"
                                                class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0"><i
                                                    class="fa-solid fa-floppy-disk"></i></button>
                                            <button type="button"
                                                class="btn bg-gradient-secondary btn-lg btn-rounded w-100 mt-4 mb-0"
                                                id="btnHuy"><i class="fa-solid fa-x"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer text-center pt-0 px-sm-4 px-1">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('assets/js/warehouse.js') }}"></script>
@endsection
