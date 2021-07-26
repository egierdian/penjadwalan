$(document).ready(function () {
    token = $("[name=token]").val();
    data = {
        _token: token
    }
    console.log(data);
    $.ajax({
        url: '/dashboard/data',
        type: 'POST',
        data: data,
        cache: false,
        success: function (res) {
            var dataResult = JSON.parse(res);
            // console.log(dataResult);
            $('#mapel').text(dataResult.mapel);
            $('#ruang').text(dataResult.ruang);
            $('#dosen').text(dataResult.dosen);
        }
    });
});