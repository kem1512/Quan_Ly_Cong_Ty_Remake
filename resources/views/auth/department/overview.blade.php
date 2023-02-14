@extends('auth.department.index')

@section('content')
    <style>
        /* width */
        ::-webkit-scrollbar {
            height: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            /* background: #f1f1f1; */
            background: transparent;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .table-borderless>tbody>tr>td>.card {
            width: 350px;
        }

        #drag {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        #child::before {
            display: inline-block;
            content: "";
            border-top: 2px solid gray;
            width: 4rem;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .child_last {
            position: relative;
        }

        .child_last::after {
            display: inline-block;
            content: "";
            border-left: 2px solid gray;
            width: 2px;
            height: 5.66rem;
            position: absolute;
            top: 0;
        }


        #parent,
        #parent_first,
        #parent_last,
        #parent_between,
        #child {
            position: relative;
        }

        #parent:after {
            display: inline-block;
            content: "";
            position: absolute;
            background-color: gray;
            height: 20px;
            width: 2px;
            left: 50%;
            top: 100%;
            transform: translate(-30%, 10%);
        }

        #parent_first:after {
            display: inline-block;
            content: "";
            border-top: 2px solid gray;
            width: 11.5em;
            position: absolute;
            top: 0;
            right: 0;
        }

        #parent_first::before {
            display: inline-block;
            content: "";
            border-left: 2px solid gray;
            width: 2px;
            height: 80px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        #parent_between::before {
            display: inline-block;
            content: "";
            border-left: 2px solid gray;
            width: 2px;
            height: 80px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        #parent_last:after {
            display: inline-block;
            content: "";
            border-top: 2px solid gray;
            width: 11.5em;
            position: absolute;
            top: 0;
            left: 0;
        }

        #parent_last::before {
            display: inline-block;
            content: "";
            border-left: 2px solid gray;
            width: 2px;
            height: 80px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
    <div class="container-fluid py-4">
        @yield('department')
        <div class="row">
            <div class="col-12" style="position: relative">
                <div style="position: absolute; width: 350px;" id="staff">
                    <div class="card">
                        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                            <p class="text-sm font-weight-bold"></p>
                        </div>

                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="{{ $departments[0]->avatar }}" class="w-100" alt="" />
                                        </div>
                                        <div class="col-8">
                                            <span class="text-primary text-uppercase text-xs font-weight-bold my-2">Chưa
                                                có</span>
                                            <p class="card-descriptio font-weight-bold mb-0">
                                                Hải Đăng
                                            </p>
                                            <a href="" class="text-info text-sm">
                                                2 nhân viên
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary btn-sm ms-auto" href="department">Quay Lại</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-2">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="d-flex justify-content-center">
                                        <td>
                                            <div class="card" id="parent">
                                                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                    <p class="text-sm font-weight-bold">{{ $departments[0]->name }}</p>
                                                </div>

                                                <div class="card-body pt-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <img src="{{ $departments[0]->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}" class="w-100"
                                                                        alt="" />
                                                                </div>
                                                                <div class="col-8">
                                                                    <span
                                                                        class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Tổng
                                                                        Giám Đốc</span>
                                                                    <p class="card-descriptio font-weight-bold mb-0">
                                                                        Hải Đăng
                                                                    </p>
                                                                    <a href="" class="text-info text-sm"
                                                                        id="btn_staff">
                                                                        2 nhân viên
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" id="drag">
                            <table class="table table-borderless">
                                <tbody class="d-flex">
                                    @php
                                        $new = $departments->shift();
                                    @endphp
                                    @foreach ($departments->all() as $department)
                                        <tr class="d-flex flex-column">
                                            @if ($loop->index == 0)
                                                <td id="parent_first">
                                                    <div class="card" style="width: 350px; margin-top: 1em">
                                                        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                            <p class="text-sm font-weight-bold text-break">
                                                                {{ $department->name }}</p>
                                                        </div>
                                                        <div class="card-body pt-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <img src="{{ $department->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                class="w-100" alt="">
                                                                        </div>
                                                                        <div class="col-8 overflow-auto">
                                                                            <span
                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">
                                                                                {{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}
                                                                            </span>
                                                                            <p
                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                Hải Đăng
                                                                            </p>
                                                                            <a href="" class="text-info text-sm"
                                                                                id="btn_staff">
                                                                                12 nhân viên
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @if ($department->department_childs->count() > 0)
                                                    @foreach ($department->department_childs as $department_child)
                                                        @if ($loop->last)
                                                            <td class="p-0">
                                                                <div class="pt-3 child_last" id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department_child->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td class="p-0">
                                                                <div style="border-left: 2px solid gray;" class="pt-3"
                                                                    id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department_child->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @elseif ($loop->last)
                                                <td id="parent_last">
                                                    <div class="card" style="width: 350px; margin-top: 1em">
                                                        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                            <p class="text-sm font-weight-bold text-break">
                                                                {{ $department->name }}</p>
                                                        </div>
                                                        <div class="card-body pt-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <img src="{{ $department->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                class="w-100" alt="">
                                                                        </div>
                                                                        <div class="col-8 overflow-auto">
                                                                            <span
                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                            <p
                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                Hải Đăng
                                                                            </p>
                                                                            <a href="" class="text-info text-sm"
                                                                                id="btn_staff">
                                                                                12 nhân viên
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if ($department->department_childs->count() > 0)
                                                    @foreach ($department->department_childs as $department_child)
                                                        @if ($loop->last)
                                                            <td class="p-0">
                                                                <div class="pt-3 child_last" id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td class="p-0">
                                                                <div style="border-left: 2px solid gray;" class="pt-3"
                                                                    id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department_child->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">Trưởng
                                                                                                Phòng Công Nghệ</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @else
                                                <td style="border-top: 2px solid gray;" id="parent_between">
                                                    <div class="card" style="width: 350px; margin-top: 1em">
                                                        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                            <p class="text-sm font-weight-bold text-break">
                                                                {{ $department->name }}</p>
                                                        </div>
                                                        <div class="card-body pt-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <img src="{{ $department->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                class="w-100" alt="">
                                                                        </div>
                                                                        <div class="col-8 overflow-auto">
                                                                            <span
                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                            <p
                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                Hải Đăng
                                                                            </p>
                                                                            <a href="" class="text-info text-sm"
                                                                                id="btn_staff">
                                                                                12 nhân viên
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @if ($department->department_childs->count() > 0)
                                                    @foreach ($department->department_childs as $department_child)
                                                        @if ($loop->last)
                                                            <td class="p-0">
                                                                <div class="pt-3 child_last" id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department_child->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td class="p-0">
                                                                <div style="border-left: 2px solid gray;" class="pt-3"
                                                                    id="child">
                                                                    <div class="card ms-3" style="width: 340px;">
                                                                        <div
                                                                            class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                                                            <p class="text-sm font-weight-bold text-break">
                                                                                {{ $department_child->name }}</p>
                                                                        </div>
                                                                        <div class="card-body pt-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <img src="{{ $department_child->avatar ?? "https://cdn-icons-png.flaticon.com/512/147/147144.png" }}"
                                                                                                class="w-100"
                                                                                                alt="">
                                                                                        </div>
                                                                                        <div class="col-8 overflow-auto">
                                                                                            <span
                                                                                                class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2 text-break">{{ $department->id_leader ? 'Có Leader' : 'Chưa Có Leader' }}</span>
                                                                                            <p
                                                                                                class="card-descriptio font-weight-bold mb-0 text-break">
                                                                                                Hải Đăng
                                                                                            </p>
                                                                                            <a href=""
                                                                                                class="text-info text-sm"
                                                                                                id="btn_staff">
                                                                                                12 nhân viên
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
