@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Department'])
    <div class="container-fluid py-4">
        @yield('department')
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-center" id="filter">
                            <input type="text" class="form-control me-3" id="name" placeholder="Tìm kiếm phòng ban">
                            <select class="form-control me-3" id="status">
                                <option value="">Hiển Thị Tất Cả</option>
                                <option value="1">Đang Hoạt Động</option>
                                <option value="0">Không Hoạt Động</option>
                            </select>
                            <select class="form-control me-3" id="per_page">
                                <option value="5">5 Kết Quả</option>
                                <option value="10">10 Kết Quả</option>
                                <option value="15">15 Kết Quả</option>
                                <option value="20">20 Kết Quả</option>
                            </select>
                            <input class="form-control" type="datetime-local" id="datetime">
                        </div>
                    </div>
                    <div class="card-body pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Mã Phòng Ban</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tên Phòng Ban</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày Thành Lập</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày Cập Nhật</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Trạng Thái</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody id="departments">
                                </tbody>
                                <tbody id="not_found">
                                    <tr>
                                        <td class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center"
                                            colspan="7">
                                            Không có dữ liệu
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('auth.department.modal')
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            clear();

            // Tự động tìm phòng ban gần đúng
            $("#department_search").on('focus', function() {
                $('#search_close').show();
            }).focusout(function() {
                setTimeout(() => {
                    $('#search_close').hide();
                }, 1000);
            }).autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{ route('department.search') }}",
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
                    $('#department_search').val(ui.item.label); // display the selected text
                    $("input[name='id_department_parent']").val(ui.item.value);
                    return false;
                }
            });

            $(document).on('click', '.staff', function() {
                $(this).remove();
            })

            // Hủy chỉnh sửa
            $('.clear').on('click', function(e) {
                e.preventDefault();
                clear();
            })

            // Thêm hoặc sửa phòng ban
            $('.save').on('click', function(e) {
                e.preventDefault()
                var form = $('#form').serialize();

                $.ajax({
                    url: '{{ route('department.createOrUpdate') }}',
                    type: 'POST',
                    data: form,
                    success: function(response) {
                        if (response.status == 0) {
                            if (response.msg.name) {
                                $(".name-error").html(response.msg.name)
                            } else {
                                $(".name-error").empty();
                            }

                            if (response.msg.code) {
                                $(".code-error").html(response.msg.code)
                            } else {
                                $(".code-error").empty();
                            }

                            if (response.msg.id_department_parent) {
                                $(".id_department_parent_error").html(response.msg
                                    .id_department_parent)
                            } else {
                                $(".id_department_parent_error").empty();
                            }
                        } else {
                            showAlert('success', response.msg);
                            clear();
                        }
                    }
                });
            })

            // Hiển thị phòng ban lên form
            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ route('department.display') }}" + '/' + id).done(function(data) {
                    $("input[name='code']").val(data.code);
                    $("input[name='name']").val(data.name);
                    if (data.status != true) {
                        $("input[name='status']").removeAttr("checked");
                    } else {
                        $("input[name='status']").attr("checked", '');
                    }
                    $.get("{{ route('department.display') }}" + '/' + data.parent_id)
                        .done(function(data) {
                            $("input[name='department_name']").val(data.name);
                            $("input[name='id_department_parent']").val(data.id);
                            $('#form').append(
                                `<input for="example-text-input" class="form-control-label" hidden name="id" value="${id}"></input>`
                            )
                            $(".clear").show()
                            clearError();
                        })
                })
            })

            // Xóa phòng ban
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('action');
                showAlert('info', 'Bạn có chắc muốn xóa không', function() {
                    $.ajax({
                        url: url,
                        data: {
                            "id": id
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == 0) {
                                showAlert('error', response.msg)
                            } else {
                                showAlert('success', response.msg)
                            }
                        }
                    });
                    clear();
                })
            })

            $(document).on('click', '.view', function() {
                // var html = ''
                // $.get('getEmployeeInDepartment' + '/' + $(this).attr('data-id'), function(response) {
                //     if (response.data) {
                //         $.each(response.data, function(i, data) {
                //             html += `<div class="d-flex mb-2">
            //             <div class="w-25">
            //                 <img class="w-100" style="border-radius: 10px" src="https://phunugioi.com/wp-content/uploads/2022/11/Hinh-anh-avatar-ff-1.jpg"/>
            //             </div>
            //             <div>
            //                 <p class="px-3 m-0">Email : ${data.email}</p>
            //                 <p class="px-3 m-0">Tên : ${data.fullname}</p>
            //                 <p class="px-3 m-0 font-weight-bold">Chức Vụ : Chủ Tịch</p>
            //             </div>
            //         </div>`;
                //         });
                //         $('.modal-body').empty().html(html);
                //     } else {
                //         $('.modal-body').empty().html("<p class='m-0'>Không Có Nhân Viên</p>");
                //     }
                // });
                $('.department').html($(this).attr('data-id'));
            })

            $(document).on('click', '.add_staff', function(e) {
                e.preventDefault();
                // var all = $(".staff").map(function() {
                //     return $(this).attr('data-id');
                // }).get();
                // console.log(all);
                var form = $('#vip').serialize();
                console.log(form);
            })

            $(document).on('dblclick', '.edit-table', function() {
                $(this).removeAttr("disabled");
                $(this).removeClass('no-border')
                $(this).focus();
                var id = $(this).attr('data-id');
                $(this).focusout(function() {
                    var name = $(this).attr('id') == 'name' ? $(this).val() : null;
                    var code = $(this).attr('id') == 'code' ? $(this).val() : null;
                    $.get("{{ route('department.display') }}" + '/' + id).done(function(data) {
                        showAlert('info', 'Bạn có chắc chắn muốn sửa',
                            function() {
                                $.ajax({
                                    url: '{{ route('department.createOrUpdate') }}',
                                    type: 'POST',
                                    data: {
                                        'id': id,
                                        'name': name ?? data.name,
                                        'id_department_parent': data
                                            .id_department_parent,
                                        'code': code ?? data.code,
                                        'status': data.status == 'on' ? 1 : 0
                                    },
                                    success: function(response) {
                                        if (response.status == 0) {
                                            if (response.msg.name) {
                                                console.log(response);
                                            }
                                            showAlert('error', response.msg)
                                        } else {
                                            clear();
                                            showAlert('success', response
                                                .msg)
                                        }
                                    }
                                });
                            })
                        clearError();
                    })
                    $(this).attr("disabled", '');
                    $(this).addClass('no-border');
                })
            })

            $(document).on('change', '.edit-checkbox', function() {
                var id = $(this).attr('data-id');
                var checked = this.checked;
                $.get("{{ route('department.display') }}" + '/' + id).done(function(data) {
                    $.ajax({
                        url: '{{ route('department.createOrUpdate') }}',
                        type: 'POST',
                        data: {
                            'id': id,
                            'name': data.name,
                            'id_department_parent': data.id_department_parent,
                            'code': data.code,
                            'status': checked ? 'on' : null
                        },
                        success: function(response) {
                            clear();
                            showAlert('success', response.msg)
                        }
                    });
                    clearError();
                })
            })

            $('#search_close').on('click', function() {
                $('#department_search').val('');
                $("input[name='id_department_parent']").val('');
                $('#search_close').hide();
            })

            $('#filter').on('change', function() {
                filter();
            })

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                if ($(this).attr('href')) {
                    $.get($(this).attr('href'), function(data) {
                        $('#departments').empty().html(data);
                    })
                }
            })

            $('[id=btn_staff]').on('click', function(e) {
                e.preventDefault();
                if ($(this).offset().left < 1500) {
                    $('#staff').offset({
                        top: $(this).offset().top,
                        left: $(this).offset().left
                    });
                } else {
                    $('#staff').offset({
                        top: $(this).offset().top,
                        left: $(this).offset().left - 260
                    });
                }
                $('#staff').css('z-index', 3000);
            })

            var clicked = false,
                clickX;
            $('#drag').on({
                'mousemove': function(e) {
                    clicked && updateScrollPos(e);
                },
                'mousedown': function(e) {
                    $(this).css('cursor', 'grab');
                    clicked = true;
                    clickX = e.pageX;
                },
                'mouseup': function() {
                    clicked = false;
                    $(this).css('cursor', 'grab');
                }
            });

            $('#staff').on('mouseleave', function() {
                setTimeout(function() {
                    $('#staff').css('z-index', -999)
                }, 300)
            })

            var updateScrollPos = function(e) {
                $('#drag').css('cursor', 'grabbing');
                $('#drag').scrollLeft($('#drag').scrollLeft() + (clickX - e.pageX) / 9.5);
            }
        })

        function clear() {
            $.get("{{ URL::to('getDepartment') }}", function(data) {
                $('#departments').empty().html(data);
            })
            $('#not_found').hide();
            $("input[name='code']").val('');
            $("input[name='name']").val('');
            $("input[name='department_name']").val('');
            $("input[name='id_department_parent']").val('');
            $("input[name='status']").attr("checked", '');
            $(".clear").hide()
            $(".code-error").empty();
            $(".name-error").empty();
            $(".id_department_parent_error").empty();
            $("#search_close").hide()
            $("input[name='id']").remove();
        }

        function filter() {
            var status = $('select#status').val();
            var per_page = $('select#per_page').val();
            var name = $('#name').val();
            var datetime = $('#datetime').val();
            $.ajax({
                url: '{{ route('department.filter') }}',
                type: 'GET',
                data: {
                    'status': status,
                    'per_page': per_page,
                    'name': name,
                    'datetime': datetime
                },
                success: function(response) {
                    $('#departments').empty().html(response);
                }
            });
        }

        function clearError() {
            $(".code-error").empty();
            $(".name-error").empty();
            $(".id_department_parent_error").empty();
        }

        function showAlert(status, msg, eventHandler) {
            if (eventHandler) {
                Swal.fire({
                    title: msg,
                    showDenyButton: true,
                    icon: status,
                    confirmButtonText: 'Đồng ý',
                    denyButtonText: "Hủy",
                }).then((result) => {
                    if (result.isConfirmed) {
                        eventHandler()
                    }
                })
            } else {
                Swal.fire({
                    icon: status,
                    title: msg,
                    timer: 1000
                })
            }
        }
    </script>
@endsection
