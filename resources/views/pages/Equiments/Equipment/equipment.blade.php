@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Kho'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body text-center">

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
@endsection

@section('javascript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('assets/js/warehouse.js') }}"></script>
@endsection
