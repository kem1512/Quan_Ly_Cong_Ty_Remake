@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="fs-3 mb-0 ">Hồ Sơ Người Dùng</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Lưu</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">THÔNG TIN NGƯỜI DÙNG</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Họ Tên</label>
                                        <input class="form-control" id="fullname_profile" type="text" name="fullname" value="{{ old('Full Name', auth()->user()->fullname) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mã Nhân Sự</label>
                                        <input class="form-control" id="personnel_code_profile" type="text" value="{{ old('Personnel code', auth()->user()->personnel_code) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        <input class="form-control" type="email" id="email_profile" name="email" value="{{ old('email', auth()->user()->email) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Số Điện Thoại</label>
                                        <input class="form-control" type="text" name="phone" id="phone_profile"  value="{{ old('Phone', auth()->user()->phone) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Quê Quán</label>
                                        <input class="form-control" type="text" name="address" id="address_profile"  value="{{ old('Phone', auth()->user()->address) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Giới Tính</label>
                                    <select class="form-control" name="gender" id="gender_profile">
                                        <option value="0" {{ old('Phone', auth()->user()->gender==0 ? 'selected':'') }} >Không được quy định</option>
                                        <option value="1" {{ old('Phone', auth()->user()->gender==1 ? 'selected':'') }} >Nam</option>
                                        <option value="2"{{ old('Phone', auth()->user()->gender==2 ? 'selected':'') }} >Nữ</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">THÔNG TIN THÊM</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', auth()->user()->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City</label>
                                        <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country</label>
                                        <input class="form-control" type="text" name="country" value="{{ old('country', auth()->user()->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code</label>
                                        <input class="form-control" type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">About me</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">About me</label>
                                        <textarea class="form-control" name="about" id="about_profile" rows="3" readonly>{{old('about', auth()->user()->about)}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <img src="/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    @if (!auth()->user()->img_url=='')
                                    <img src="./file/{{auth()->user()->img_url}}"
                                    class="rounded-circle img-fluid border border-2 border-white">
                                    @else
                                    <img src="/img/team-2.jpg"
                                    class="rounded-circle img-fluid border border-2 border-white">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                        <div class="d-flex justify-content-between">
                            <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                            <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                    class="ni ni-collection"></i></a>
                            <a href="javascript:;"
                                class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                            <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                    class="ni ni-email-83"></i></a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-center">
                                    <div class="d-grid text-center">
                                        <span class="text-lg font-weight-bolder">22</span>
                                        <span class="text-sm opacity-8">Thành Tích</span>
                                    </div>
                                    <div class="d-grid text-center mx-4">
                                        <span class="text-lg font-weight-bolder">10</span>
                                        <span class="text-sm opacity-8">Khen Thưởng</span>
                                    </div>
                                    <div class="d-grid text-center">
                                        <span class="text-lg font-weight-bolder">89</span>
                                        <span class="text-sm opacity-8">Nhận Xét</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                           
                            <h5>
                                {{ old('fullname', auth()->user()->fullname ?? 'Chưa có tên') }} <span class="font-weight-light">,{{$age}}</span>
                            </h5>
                            @if (!auth()->user()->address=='')
                            <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ old('address', auth()->user()->address ?? '') }}
                            </div> 
                            @endif
                            @if (!auth()->user()->title=='')
                            <div class="h6 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ old('title', auth()->user()->title) }}
                            </div>   
                            @endif
                            
                            <div>
                                <i class="ni education_hat mr-2"></i>SCONNECT.NET
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
