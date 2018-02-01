$(function () {
    $('#btnCancel').click(function () {
        window.location.href = "?controller=admin-user&action=list";
    });
    $('#btnSave').click(function () {
        var group = $('select#groupUser option:selected').val();
        var name = $("#fullName").val();
        var pass = $("#password").val();
        var email = $("#email").val();
        var user = $("#userName").val();
        $.post("?controller=admin-user&action=edit&ajax=1", {
            user: user,
            name: name,
            pass: pass,
            email: email,
            group: group
        })
            .done(function (data) {
                alert(data);
                //window.location.href = "?controller=admin-user&action=list";
            });
    });
});