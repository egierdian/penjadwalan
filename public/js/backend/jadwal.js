let table;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $("[name=csrf-token]").val()
        }
    });
    table = $('#table-jadwal').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/jadwal",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'hari', name: 'hari' },
            { data: 'mapel', name: 'mapel' },
            { data: 'dosen', name: 'dosen' },
            { data: 'mulai', name: 'mulai' },
            { data: 'selesai', name: 'selesai' },
            { data: 'ruang', name: 'ruang' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']]
    });
    $("#content-jadwal").hide();
    list_dosen();
    list_ruang();
    list_mapel();
});

function save() {
    let hari = $('#Hari').val();
    let mulai = $('#Mulai').val();
    let selesai = $('#Selesai').val();
    let status = $('#Status').val();
    let JadwalID = $('[name=JadwalID]').val();
    let DosenID = $('#DosenID').val();
    let MapelID = $('#MapelID').val();
    let RuangID = $('#RuangID').val();
    $("#btnSave").text('Menyimpan..');
    $("#btnSave").attr('disabled', true);
    if (JadwalID) {
        id = JadwalID;
        url = "/jadwal/post/" + id;
    } else {
        id = '';
        url = "/jadwal/post";
    }
    data_post = {
        _token: $("#csrf").val(),
        type: 1,
        id: id,
        hari: hari,
        id_ruang : RuangID,
        id_dosen : DosenID,
        id_mapel : MapelID,
        status : status,
        mulai : mulai,
        selesai: selesai,
        hari : hari
    };
    if (RuangID != 'none' && DosenID != 'none' && MapelID != 'none' && mulai != '' && selesai != '' && hari != '') {
        $.ajax({
            url: url,
            type: "POST",
            data: data_post,
            cache: false,
            success: function (res) {
                var dataResult = JSON.parse(res);
                console.log(dataResult);
                if (dataResult.status) {
                    Swal.fire(
                        'Success',
                        dataResult.message,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Error',
                        'error'
                    );
                }
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                $('#form-jadwal')[0].reset();
                $('[name=JadwalID]').val('');
                $('#RuangID').val('none');
                $('#DosenID').val('none');
                $('#MapelID').val('none');
                reload_table();
            }
        });
    }
    else {
        Swal.fire(
            'Info',
            'Please fill all the field !',
            'info'
        );
        $("#btnSave").text('Save');
        $("#btnSave").attr('disabled', false);
    }
};

function add() {
    $('#content-jadwal').show(300);
    $('#form-jadwal')[0].reset();
    $('[name=JadwalID]').val('');
    $('#RuangID').val('none');
    $('#DosenID').val('none');
    $('#MapelID').val('none');
}
function close_form() {
    $('#content-jadwal').hide(300);
}
function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
}
function edit(id) {
    $.ajax({
        url: "/jadwal/edit/" + id,
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            type: 1,
            id: id,
        },
        success: function (res) {
            console.log(res);
            var dataResult = JSON.parse(res);
            if (dataResult.status) {
                $('#content-jadwal').show(300);
                $('#Hari').val(dataResult.data.hari);
                $('#Mulai').val(dataResult.data.mulai);
                $('#Selesai').val(dataResult.data.selesai);
                $('#Status').val(dataResult.data.status);
                $('#DosenID').val(dataResult.data.id_dosen);
                $('#RuangID').val(dataResult.data.id_ruang);
                $('#MapelID').val(dataResult.data.id_mapel);
                $('[name=JadwalID]').val(dataResult.data.id);
            }
        }
    });
}
function delete_data(id){
    $.ajax({
        url: "/jadwal/delete/" + id,
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            type: 1,
            id: id,
        },
        success: function (res) {
            var dataResult = JSON.parse(res);
            if (dataResult.status) {
                Swal.fire(
                    'Success',
                    dataResult.message,
                    'success'
                );
                reload_table();
            } else {
                Swal.fire(
                    'Error',
                    'Error',
                    'error'
                );
            }
        }
    });
}
function list_dosen(){
    let item = '';
    $.ajax({
        url: "/jadwal/list_dosen",
        type: "POST",
        data: {
            _token: $("#csrf").val(),
        },
        success: function (res) {
            var dataResult = JSON.parse(res);
            console.log(dataResult);
            $.each( dataResult.data_dosen, function( key, value ) {
                item += "<option value="+value.id+">"+value.nama+"</option>";
                
            });
            $("#DosenID").append(item);
        }
    });
}


function list_mapel(){
    let item = '';
    $.ajax({
        url: "/jadwal/list_mapel",
        type: "POST",
        data: {
            _token: $("#csrf").val(),
        },
        success: function (res) {
            var dataResult = JSON.parse(res);
            console.log(dataResult);
            $.each( dataResult.data_mapel, function( key, value ) {
                item += "<option value="+value.id+">"+value.nama+"</option>";
                
            });
            $("#MapelID").append(item);
        }
    });
}


function list_ruang(){
    let item = '';
    $.ajax({
        url: "/jadwal/list_ruang",
        type: "POST",
        data: {
            _token: $("#csrf").val(),
        },
        success: function (res) {
            var dataResult = JSON.parse(res);
            console.log(dataResult);
            $.each( dataResult.data_ruang, function( key, value ) {
                item += "<option value="+value.id+">"+value.nama+"</option>";
                
            });
            $("#RuangID").append(item);
        }
    });
}