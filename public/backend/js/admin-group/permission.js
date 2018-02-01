$(function () {
    // Lấy giá trị tử select box gửi lên sever để nhận dữ liệu json
    upData($("#selectPicker option:selected").val().split('#')[0]);
    $("#selectPicker").change(function () {
        var val = $(this).symbCost(0);
        upData(val)
    });
    $.fn.symbCost = function (pos) {
        var total = parseInt($("option:selected").val().split('#')[pos]);
        return total;
    };
    $("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    $("#btn-save").click(function () {
        var data = $("#mytable tr:gt(0)").map(function () {
            return {
                id: $('td:first', $(this)).html(),
                check: $(this).find('input').prop("checked").toString(),
                id_nhom: $("#selectPicker option:selected").val().split('#')[0]
            };
        }).get();
        var u = $("#selectPicker option:selected").val().split('#')[0];
        $.ajax({
            type: "POST",
            url: "?controller=admin-group&action=permission&ajax=1",
            data: "content=" + JSON.stringify(data)
        }).done(function (data) {
            alert(data);
        })
    });
});

function upData(x) {
    $.post('?controller=admin-group&action=permission&ajax=1', {id: x})
        .done(function (data) {
            var json = JSON.parse(data);
            $('#mytable tr').each(function () {
                $(this).find('input').prop("checked", false);
                var x = $('td:first', $(this)).html();
                try {
                    if (json[x - 1].trang_thai === '1') {
                        $(this).find('input').prop("checked", true);
                    }
                    else {
                        $(this).find('input').prop("checked", false);
                    }
                } catch (e) {
                    $(this).find('input').prop("checked", false);
                }
            });
        });
}

