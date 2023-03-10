<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header text-center">
        <h3 id="offcanvasRightLabel ">Thêm Thiết Bị</h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fa fa-times" aria-hidden="true"></i></button>
    </div>
    <div class="offcanvas-body">
        <form id="submit_insert_equipment" class="row d-flex mt-5" method="post">
            <div class="col-md-6">
                <div class="card" style="width: 90%;">
                    <img src="https://i0.wp.com/thatnhucuocsong.com.vn/wp-content/uploads/2022/09/anh-anime-chibi.jpg?ssl=1"
                        class="card-img-top" alt="...">
                    <div class="card-body">
                        <input type="file" name="img_equipment" onchange="readURL(this);" class="form-control"
                            id="img_equipment">
                    </div>
                </div>
            </div>
            <div class="col-md-6 row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="col-4 col-form-label w-100">Tên Thiết Bị</label>
                        <input class="form-control " name="equipment_name" id="equipment_name"
                            placeholder="Tên thể loại...">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="col-4 col-form-label w-100">Thể Loại</label>
                        <select class="form-control " name="equipment_type" id="equipment_type">
                            <option value="1">Tai Nghe</option>
                            <option value="0">Bàn Phím</option>
                            <option value="0">Linh kiện</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="col-4 col-form-label w-100">Số lượng</label>
                        <input class="form-control " type="number" name="interviewer2" id="interviewer2"
                            placeholder="Số lượng...">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="col-sm-4 col-form-label">Ngày</label>
                        <input class="form-control " type="date" name="interview_date" id="interview_date"
                            value="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="col-sm-4 col-form-label">giờ</label>
                        <input class="form-control " type="time" name="interview_time" id="interview_time"
                            value="">
                    </div>
                </div>
            </div>





            <div class="col-md-6">
                <div class="form-group">
                    <label for="example-text-input" class="col-sm-4 col-form-label w-100">Hình
                        Thức</label>
                    <select class="form-control " name="cate_inter" id="cate_inter">
                        <option value="1">Trực Tiếp</option>
                        <option value="0">online</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label id="location-text" for="example-text-input" class="col-sm-4 col-form-label">Địa
                        Chỉ</label>
                    <input class="form-control " type="text" id="interview_location" name="interview_location">
                </div>
            </div>
            <div class="wrapper col-md-12 mt-5 d-flex justify-content-around">
                <button type="submit" class="btn btn-success">Thêm</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop_equipment_type">
                    Thể Loại
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop_supplier">
                    Nhà Cung Cấp
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop_equipment_type" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Quản Lý Thể Loại</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body" style="min-height: 50vh; min-width: 90% !important;">
                <div class="rom-add-type w-100">
                    <div class="mb-3 row">
                        <label for="equipment_type" class="col-sm-3 col-form-label">Thể Loại</label>
                        <div class="col-sm-5">
                            <input type="text" name="equipment_type" id="equipment_type" class="form-control"
                                placeholder="Tên Thể loại..." />
                        </div>
                        <div class="col-2 mt-2"><input type="checkbox" name="ischild" id="ischild"> child
                        </div>
                        <div class="col-1 align-items-center"><a href="" class="btn btn-success">Lưu</a></div>
                    </div>
                    <div class="mt-4">
                        <h5 class="text-center">Các thể loại</h5>
                    </div>
                </div>
                <div class="show-cate w-100">
                    <div id="list_equipment_type_build">
                        <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                            <a class="justify-content-start col-8 ">
                                <i class="ni ni-fat-delete"></i>Tai Nghe</a>
                            <div class="col-4 d-flex justify-content-end">
                                <a onclick="" class="text-sm font-weight-bold mb-0 " id="btn_autho_update"
                                    style="cursor: pointer">Sửa
                                </a>
                                | <a class="text-sm font-weight-bold mb-0 " onclick="" id="btn_autho_delete"
                                    style="cursor: pointer">
                                    Xóa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop_supplier" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Quản Lý Nhà Cung Cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body" style="min-height: 50vh; min-width: 90% !important;">
                <div class="rom-add-type w-100">
                    <div class="mb-3 row">
                        <label for="equipment_type" class="col-sm-4 col-form-label">Nhà Cung Cấp</label>
                        <div class="col-sm-6">
                            <input type="text" name="equipment_type" id="equipment_type" class="form-control"
                                placeholder="Tên đơn vị..." />
                        </div>
                        <div class="col-1 align-items-center"><a href="" class="btn btn-success">Lưu</a></div>
                    </div>
                    <div class="mt-4">
                        <h5 class="text-center">Các Nhà Cung Cấp Hiện Có</h5>
                    </div>
                </div>
                <div class="show-cate w-100">
                    <div id="list_supplier_build">
                        <div class="w-100 row  p-2 mb-1 justify-content-between d-flex  rounded">
                            <a class="justify-content-start col-8 ">
                                <i class="ni ni-fat-delete"></i>Apple</a>
                            <div class="col-4 d-flex justify-content-end">
                                <a onclick="" class="text-sm font-weight-bold mb-0 " id="btn_supplier_update"
                                    style="cursor: pointer">Sửa
                                </a>
                                | <a class="text-sm font-weight-bold mb-0 " onclick="" id="btn_supplier_delete"
                                    style="cursor: pointer">
                                    Xóa</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
