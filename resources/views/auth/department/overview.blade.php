@extends('auth.department.index')

@section('content')
    <div class="container-fluid py-4">
        @yield('department')
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="card-body">
                        @foreach ($departments as $department)
                            <div class="col-md-12">
                                <div class="row justify-content-center">
                                    <div class="col-md-3">
                                        <div class="card flex-sm-row align-items-center">
                                            <div class="w-25">
                                                <img src="https://c3kienthuyhp.edu.vn/wp-content/uploads/2022/12/1672365681_454_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg"
                                                    class="card-img-top" alt="...">
                                            </div>
                                            <div class="card-body">
                                                <p class="card-title text-sm text-bolder">{{ $department->name }}</p>
                                                <div class="d-flex">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-auto-close="outside"
                                                            class="btn btn-xs bg-gradient-dark dropdown-toggle me-2"
                                                            data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
                                                            {{ $department->users->count() }} Nhân Viên
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                            @foreach ($department->users as $user)
                                                                <li style="width: 250px">
                                                                    <div class="d-flex p-2">
                                                                        <img src="{{ $user->img_url }}"
                                                                            class="rounded-circle me-3" style="width: 30%"
                                                                            class="me-2">
                                                                        <div>
                                                                            <span
                                                                                class="text-sm text-bolder">{{ $user->fullname }}</span><br>
                                                                            <span class="text-xs">Chức Vụ : Ông
                                                                                Trời</span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($department->children as $child1)
                                        <div class="col-md-3 mt-3">
                                            <div class="card flex-sm-row align-items-center mb-3">
                                                <div class="w-25">
                                                    <img src="https://c3kienthuyhp.edu.vn/wp-content/uploads/2022/12/1672365681_454_222-Hinh-Anh-Avatar-FF-Dep-Chat-Ngat-AI-CUNG.jpg"
                                                        class="card-img-top" alt="...">
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-title text-sm text-bolder">{{ $child1->name }}
                                                    </p>
                                                    <div class="d-flex">
                                                        <div class="dropdown">
                                                            <a href="#" data-bs-auto-close="outside"
                                                                class="btn btn-xs bg-gradient-dark dropdown-toggle me-2"
                                                                data-bs-toggle="dropdown" id="navbarDropdownMenuLink2"> {{ $child1->users->count() }} Nhân Viên
                                                            </a>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="navbarDropdownMenuLink2">
                                                                @foreach ($child1->users as $user)
                                                                    <li style="width: 250px">
                                                                        <div class="d-flex p-2">
                                                                            <img src="{{ $user->img_url }}"
                                                                                class="rounded-circle me-3"
                                                                                style="width: 30%" class="me-2">
                                                                            <div>
                                                                                <span
                                                                                    class="text-sm text-bolder">{{ $user->fullname }}</span><br>
                                                                                <span class="text-xs">Chức Vụ : Ông
                                                                                    Trời</span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($child1->children as $child2)
                                                <div class="card flex-sm-row align-items-center">
                                                    <div style="width: 35%">
                                                        <img src="https://img6.thuthuatphanmem.vn/uploads/2022/09/21/anh-avatar-ff-cool-ngau-dep_092531137.jpg"
                                                            class="card-img-top" alt="...">
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-title text-sm text-bolder">
                                                            {{ $child2->name }}</p>
                                                        <div class="d-flex">
                                                            <div class="dropdown">
                                                                <a href="#"
                                                                    class="btn btn-xs bg-gradient-dark dropdown-toggle me-2"
                                                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                                    id="navbarDropdownMenuLink2">
                                                                    {{ $child2->users->count() }}
                                                                    Nhân Viên
                                                                </a>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="navbarDropdownMenuLink2">
                                                                    @foreach ($child2->users as $user)
                                                                        <li style="width: 250px">
                                                                            <div class="d-flex p-2">
                                                                                <img src="{{ $user->img_url }}"
                                                                                    style="width: 30%"
                                                                                    class="me-3 rounded-circle">
                                                                                <div>
                                                                                    <span
                                                                                        class="text-sm text-bolder">{{ $user->fullname }}</span><br>
                                                                                    <span class="text-xs">Chức
                                                                                        Vụ : Ông
                                                                                        Trời</span>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <button
                                                                data-bs-target="#flush-collapse-child-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                                aria-expanded="false"
                                                                class="btn btn-xs bg-gradient-success dropdown-toggle {{ $child2 -> children -> count() > 0 ? 'd-block' : 'd-none' }}"
                                                                type="button" id="dropdownMenuButton"
                                                                data-bs-toggle="collapse" aria-expanded="false">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion accordion-flush mb-3" id="accordionFlushExample">
                                                    <div class="accordion-item">

                                                        <div id="flush-collapse-child-{{ $loop->parent->index }}-{{ $loop->index }}"
                                                            class="accordion-collapse collapse">
                                                            <div class="accordion-body text-danger">
                                                                @foreach ($child2->children as $child3)
                                                                    <div class="card flex-sm-row align-items-center">
                                                                        <div class="w-25">
                                                                            <img src="https://kynguyenlamdep.com/wp-content/uploads/2022/08/avatar-ff-ngau.jpg"
                                                                                class="card-img-top" alt="...">
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <p class="card-title text-sm text-bolder">
                                                                                {{ $child3->name }}</p>
                                                                            <div class="d-flex">
                                                                                <div class="dropdown">
                                                                                    <a href="#"
                                                                                        data-bs-auto-close="outside"
                                                                                        class="btn btn-xs bg-gradient-dark dropdown-toggle me-2"
                                                                                        data-bs-toggle="dropdown"
                                                                                        id="navbarDropdownMenuLink2">
                                                                                        {{ $child3->users->count() }} Nhân
                                                                                        Viên
                                                                                    </a>
                                                                                    <ul class="dropdown-menu"
                                                                                        aria-labelledby="navbarDropdownMenuLink2">
                                                                                        @foreach ($child3->users as $user)
                                                                                            <li style="width: 250px">
                                                                                                <div class="d-flex p-2">
                                                                                                    <img src="{{ $user->img_url }}"
                                                                                                        class="rounded-circle me-3"
                                                                                                        style="width: 30%"
                                                                                                        class="me-2">
                                                                                                    <div>
                                                                                                        <span
                                                                                                            class="text-sm text-bolder">{{ $user->fullname }}</span><br>
                                                                                                        <span
                                                                                                            class="text-xs">Chức
                                                                                                            Vụ : Ông
                                                                                                            Trời</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
