@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Thiết Bị'])

    @yield('equipment')
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <ul class="nav nav-tabs justify-content-around border-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true" style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Thiết Bị</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>

                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false"style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Bàn Giao</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>

                <li class="nav-item" role="presentation" style="border-radius: 0.5rem;background: gainsboro; ">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false"style="border-radius: 0.5rem ">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Kho</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- MAIN CONTENT  --}}
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="tab-content mh-71vh" id="myTabContent">
                    {{-- ===================================================================Thieets Bi =================================================================== --}}
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class=" d-flex justify-content-between">
                                    <h5>Thiết Bị</h5>
                                    <!-- Button trigger modal -->
                                    <div class="wraper-btn">
                                        <button class="btn btn-success" id="btn-add-equipment" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Thêm</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="row m-1 d-flex justify-content-between">
                                    <div class="col-6 p-2" id="table_equipment" style="min-height: 40vh;">
                                        {!! \App\Models\Equipment::biuld_equipment($equipments) !!}
                                    </div>
                                    <div class="col-6 p-1 " id="table_equipment_detail" style="min-height: 40vh;">
                                        {!! \App\Models\EquipmentDetail::build_equipment_detail($equipment_detail, $equiment) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- =================================================================== Thiết Bị=================================================================== --}}

                    {{-- =================================================================== Bàn Giao =================================================================== --}}
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class=" d-flex justify-content-between">
                                    <h5>Bàn Giao</h5>
                                    <a href="" class="btn btn-success">Ban Giao</a>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ===================================================================Bàn Giao =================================================================== --}}

                    {{-- =================================================================== Kho =================================================================== --}}
                    <div class="tab-pane fade row " id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        {{-- // --}}
                        <div class="card col-12">
                            <div class="card-header pb-0 ">
                                <div class=" d-flex bd-highlight " style="align-items: baseline;">
                                    <h1>Kho</h1>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2 row">
                            </div>
                        </div>
                    </div>
                    {{-- =================================================================== Kho =================================================================== --}}
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    @include('pages.Equiments.module.form_equipment')
@endsection
