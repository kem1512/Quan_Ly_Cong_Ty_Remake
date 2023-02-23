var id_users = 0;
var keyword = "";


$(document).ready(function () {
    changtype();
    ChonBenChuyen();
    ChonBenNhan();
    GetStoreHouse();
    ChangeStoreHouse();
    GetNhanSuBanGiao();
    CancelBenChuyen();
    GetNhanSuNhan();
    CancelBenNhan();
    chooseEquipment();
});

function changtype() {
    $('#changtype').on('change', function () {
        $('#changtype').val() == "hand-over" ? $('#divchuyen').css('display', 'block') : $('#divchuyen').css('display', 'none');
        $('#btnSave').text($('#changtype').val() == "hand-over" ? "Thực hiện bàn giao" : "Thực hiện thu hồi");
    });
}

function ChonBenChuyen() {
    $('#btnBenChuyen').on('click', function () {
        $('#exampleModal').modal('show');
        $('#exampleModalLabel').text('Chọn bên chuyển');

        let url = id_users == 0 ? '/transfer/getnhansu' : '/transfer/getnhansu/' + id_users;

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                let html = '';
                $.each(response.users, function (index, value) {
                    html += '<tr>\
                                <td><img class="rounded-circle img-fluid w-25" src="'+ (value.img_url == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.img_url) + '"></td>\
                                <td>'+ value.fullname + '</td>\
                                <td><button id="btnChonChuyen" name="'+ value.id + '" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>\
                            </tr>';
                });
                $('#chooseuser').html(html);
            }
        });
    })
}

function ChonBenNhan() {
    $('#btnBenNhan').on('click', function () {
        $('#exampleModal').modal('show');
        $('#exampleModalLabel').text('Chọn bên nhận');

        $('#exampleModal').modal('show');
        $('#exampleModalLabel').text('Chọn bên chuyển');

        let url = id_users == 0 ? '/transfer/getnhansu' : '/transfer/getnhansu/' + id_users;

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                let html = '';
                $.each(response.users, function (index, value) {
                    html += '<tr>\
                                    <td><img class="rounded-circle img-fluid w-25" src="'+ (value.img_url == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.img_url) + '"></td>\
                                    <td>'+ value.fullname + '</td>\
                                    <td><button id="btnChonNhan" name="'+ value.id + '" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>\
                                </tr>';
                });
                $('#chooseuser').html(html);
            }
        });
    })
}

function GetStoreHouse() {
    $.ajax({
        type: "get",
        url: "/transfer/getstorehouse/" + keyword,
        dataType: "json",
        success: function (response) {
            let html = '';
            $.each(response.equipment, function (index, value) {
                html += `<tr>
                            <td>${index + 1}</td>
                            <td><img class="rounded-circle img-fluid" style="width: 100px;height: 100px" src="${(value.image == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.image)}"/></td>
                            <td>${value.name}</td>
                            <td>${value.amount}</td>
                            <td><button id="ChonTrongKho" class="btn btn-primary">Chọn</button></td>
                        </tr>`;
            });
            $('#list_storehouse').html(html);
        }
    });
}

function ChangeStoreHouse() {
    $('#storehouse_select').on('change', function () {
        keyword = $(this).val();
        GetStoreHouse();
    });
}

function GetNhanSuBanGiao() {
    $(document).on('click', '#btnChonChuyen', function () {
        let id = $(this).attr('name');

        $.ajax({
            type: "get",
            url: "/transfer/getusedetail/" + id,
            dataType: "json",
            success: function (response) {
                if (response.usedetails.length != 0) {
                    let html = '';
                    $.each(response.usedetails, function (index, value) {
                        html += '<tr>\
                                    <td>'+ (index + 1) + '</td>\
                                    <td>'+ value.image + '</td>\
                                    <td>'+ value.name + '</td>\
                                    <td>'+ value.amount + '</td>\
                                    <td><button class="btn btn-primary">Chọn</button></td>\
                                </tr>';
                        $('#txtNameChuyen').val(value.fullname);
                        $('#txtNameChuyen').prop('disabled', true);
                        $('#txtNameChuyen').attr('name', value.id);
                        id_users = value.id;
                        $('#imgBenChuyen').css('display', 'block');
                        if (value.img_url == null) {
                            $('#imgBenChuyen').attr('src', "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg");
                        } else {
                            $('#imgBenChuyen').attr('src', value.img_url);
                        }

                    });
                    $('#list_storehouse').html(html);
                    $('#btnHuy').css('display', 'block');
                    $('#exampleModal').modal('hide');
                    $('#btnBenChuyen').css('display', 'none');
                } else {
                    $('#exampleModal').modal('hide');
                    id_users = 0;
                }
            }
        });
    });
}

function GetNhanSuNhan() {
    $(document).on('click', '#btnChonNhan', function () {
        let id = $(this).attr('name');
        $.ajax({
            type: "get",
            url: "/personnel/edit",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $('#txtBenNhan').val(response.data.fullname);
                $('#txtBenNhan').prop('disabled', true);
                $('#txtBenNhan').attr('name', response.data.id);
                $('#exampleModal').modal('hide');
                $('#btnBenNhan').css('display', 'none');
                $('#btnHuyBenNhan').css('display', 'block');
                $('#imgbennhan').css('display', 'block');
                if (response.data.img_url == null) {
                    $('#imgbennhan').attr('src', "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg");
                } else {
                    $('#imgbennhan').attr('src', response.data.img_url);
                }
                id_users = response.data.id;
            }
        });
    });
}

function CancelBenChuyen() {
    $('#btnHuy').on('click', function () {
        $('#btnHuy').css('display', 'none');
        $('#txtNameChuyen').val("");
        $('#txtNameChuyen').prop('disabled', false);
        $('#btnBenChuyen').css('display', 'block');
        $('#txtNameChuyen').attr('name', '');
        let idbennhan = $('#txtBenNhan').attr('name');
        id_users = idbennhan == "" ? 0 : idbennhan;
        $('#imgBenChuyen').attr('src', "");
        $('#imgBenChuyen').css('display', 'none');
        GetStoreHouse();
    });
}

function CancelBenNhan() {
    $('#btnHuyBenNhan').on('click', function () {
        $('#txtBenNhan').val("");
        $('#txtBenNhan').prop('disabled', false);
        $('#btnBenNhan').css('display', 'block');
        $('#btnHuyBenNhan').css('display', 'none');
        $('#txtBenNhan').attr('name', '');
        $('#imgbennhan').css('display', 'none');
        let idbenchuyen = $('#txtNameChuyen').attr('name');
        id_users = idbenchuyen == "" ? 0 : idbenchuyen;
        $('#imgbennhan').attr('src', "");
    });
}

function chooseEquipment() {
    $(document).on('click', '#ChonTrongKho', function () {

    });
}
