var id_users = 0;
var keyword = "";
var arrEquipment = [];


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
    DisplayEquipmentTranfer();
    UpdateAmountTransfer();
    arrEquipment = JSON.parse(sessionStorage.getItem('arr')) == null ? [] : JSON.parse(sessionStorage.getItem('arr'));
    if (arrEquipment.length != 0) {
        DisplayEquipmentTranfer();
    }
    SaveTransfer();
});

function changtype() {
    $('#changtype').on('change', function () {
        $('#changtype').val() == "hand_over" ? $('#divchuyen').css('display', 'block') : $('#divchuyen').css('display', 'none');
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
                    html += `<tr>
                                <td><img class="rounded-circle img-fluid w-25" src="${(value.img_url == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.img_url)}"></td>
                                <td>${value.fullname}</td>
                                <td><button id="btnChonChuyen" name="${value.id}" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>
                            </tr>`;
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
                    html += `<tr>
                                    <td><img class="rounded-circle img-fluid w-25" src="${(value.img_url == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.img_url)}"></td>
                                    <td>${value.fullname}</td>
                                    <td><button id="btnChonNhan" name="${value.id}" class="btn btn-primary"><i class="fa-solid fa-check"></i></button></td>
                                </tr>`;
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
                                <td><button id="ChonTrongKho" name="${value.id}" idstorehouse="${value.id_storehouse_detail}" amountkho="${value.amount}" class="btn btn-primary">Chọn</button></td>
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
                sessionStorage.clear();
                arrEquipment = [];
                DisplayEquipmentTranfer();
                if (response.usedetails != 0) {
                    let html = '';
                    $.each(response.usedetails, function (index, value) {
                        html += `<tr>
                                    <td>${(index + 1)}</td>
                                    <td><img class="rounded-circle img-fluid" style="width: 100px;height: 100px" src="${(value.image == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.image)}"</td>
                                    <td>${value.name}</td>
                                    <td id="amountnhansu">${value.amount}</td>
                                    <td><button id="ChonTrongKho" name="${value.id}" class="btn btn-primary">Chọn</button></td>
                                </tr>`;

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
        arrEquipment = [];
        DisplayEquipmentTranfer();
        GetStoreHouse();
        sessionStorage.clear();
        arrEquipment = [];
        DisplayEquipmentTranfer();
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

        let id = $(this).attr('idstorehouse');
        let amountkho = $(this).attr('amountkho');


        $.ajax({
            type: "get",
            url: "transfer/getequipmentbyid/" + id,
            dataType: "json",
            success: function (response) {
                let equip = new equipment(response.equipment[0].id_storehouse_detail, response.equipment[0].id, response.equipment[0].image, response.equipment[0].name, 1);
                if (arrEquipment.length == 0) {
                    arrEquipment.push(equip);
                    DisplayEquipmentTranfer();
                } else {

                    let check = arrEquipment.some(e => e.id == equip.id && e.id_storehouse == equip.id_storehouse);
                    if (!check) {
                        let newArr = [];
                        newArr.push(equip);
                        for (const equip of newArr) {
                            arrEquipment.push(equip);
                        }
                        DisplayEquipmentTranfer();
                    } else {
                        for (const eqip of arrEquipment) {
                            if (eqip.id == equip.id && eqip.id_storehouse == equip.id_storehouse) {
                                if (eqip.amount < amountkho) {
                                    eqip.amount++;
                                    DisplayEquipmentTranfer();
                                } else {
                                    Swal.fire(
                                        'Cảnh báo!',
                                        'Đã vượt quá số lượng thiết bị!',
                                        'warning'
                                    )
                                }
                            }
                        }
                    }
                }

                window.sessionStorage.setItem('arr', JSON.stringify(arrEquipment));
            }
        });
    });
}

function DisplayEquipmentTranfer() {
    let html = '';
    $.each(arrEquipment, function (index, value) {
        html += `<tr>
                    <td>${(index + 1)}</td>
                    <td><img class="rounded-circle img-fluid" style="width: 100px;height: 100px" src="${(value.image == null ? "https://haycafe.vn/wp-content/uploads/2021/11/Anh-avatar-dep-chat-lam-hinh-dai-dien.jpg" : value.image)}"</td>
                    <td>${value.name}</td>
                    <td id="amounttrans">${value.amount}</td>
                    <td><button id="btnUpdateAmountTransfer" name="${value.id}" amounttransfer="${value.amount}" class="btn btn-primary">Xóa</button></td>
                </tr>`;
    });
    $('#list-equiment-storehouse').html(html);
}

function UpdateAmountTransfer() {
    $(document).on('click', '#btnUpdateAmountTransfer', function () {
        let id = $(this).attr('name');
        let amount = $(this).attr('amounttransfer');
        for (const value of arrEquipment) {
            if (value.id == id) {
                if (amount > 1) {
                    amount--;
                    value.amount = amount;
                    DisplayEquipmentTranfer();
                } else {
                    let newarr = arrEquipment.filter(item => item !== value);
                    arrEquipment = newarr;
                    window.sessionStorage.setItem('arr', JSON.stringify(arrEquipment));
                    DisplayEquipmentTranfer();
                }
            }
        }
    });
}

class equipment {

    constructor(id_storehouse_detail, id, image, name, amount) {
        this.amount = amount;
        this.id = id;
        this.id_storehouse_detail = id_storehouse_detail;
        this.image = image;
        this.name = name;
    }

    id_storehouse_detail;
    id;
    image;
    name;
    amount;
}

function SaveTransfer() {
    $('#btnSave').on('click', function () {
        let user_transfer_id = $('#txtNameChuyen').attr('name');
        let user_receive_id = $('#txtBenNhan').attr('name');
        let performer_id = $('#txtInfo').attr('name');
        let transfer_type = $('#changtype').val();
        let transfer_detail = $('#txtchitiet').val();
    })
}



