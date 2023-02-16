@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <form id="vip">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0">Thêm Nhân Viên Vào Phòng Ban</p>
                                <button class="btn btn-primary btn-sm ms-auto save me-2">
                                    Lưu thông tin
                                </button>
                                <button class='btn btn-primary btn-sm clear'>Hủy</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control" id="user_search" type="text">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="container_staff">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    <script>
        $(document).on("#user_search").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "{{ route('department.searchUsers') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#container_staff').append(
                    `<input value='${ui.item.label}' class="btn btn-primary position-relative me-2 staff" name='users[]'></input>`
                )
                return false;
            }
        });
    </script>
@endsection
