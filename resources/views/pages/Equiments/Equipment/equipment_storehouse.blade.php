@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kho'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="/warehouse">Quay lại danh sách kho</a>
                    </div>
                    <div>
                        <h5 id="idkho" name="{{ $id_kho }}">{{ $name_kho }}</h5>
                    </div>
                    <div>
                        <select id="selectperpage" class="form-control">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ảnh thiết bị</th>
                                <th>Tên thiết bị</th>
                                <th>Ngày hết hạn</th>
                                <th>Ngày hết bảo hành</th>
                                <th>Số lượng</th>
                                <th>Ngày nhập kho</th>
                                <th colspan="2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="store-house-detail">

                        </tbody>
                    </table>
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
        @include('components.modal_them_thiet_bi')
    </div>
@endsection

@section('javascript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('assets/js/warehousedetail.js') }}"></script>
@endsection