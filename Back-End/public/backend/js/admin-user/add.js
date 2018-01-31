$(function () {
    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };

    $('#btnCancel').click(function () {
        window.location.href = "?controller=admin-user&action=list";
    });
    $('#btnSave').click(function () {
        /*var group = $('select#groupUser option:selected').val();
        var name = $("#fullName").val();
        var pass = $("#password").val();
        var email = $("#email").val();
        var user = $("#userName").val();
        $.post("?controller=admin-user&action=edit", {
            user: user,
            name: name,
            pass: pass,
            email: email,
            group: group
        })
            .done(function (data) {
                window.location.href = "?controller=admin-user&action=list";
            });*/
        var userName = $("#userName").val();
        var name = $("#fullName").val();
        var email = $("#email").val();
        var pass = $("#password").val();
        var pass2 = $("#REpassword").val();
        var group = $('select#groupUser option:selected').val();
        if (name.length === 0) {
            alert("Không được để trống Họ Tên");
        }
        else if (userName.length === 0) {
            alert("Không được để trống Username");
        }
        else if (email.length === 0) {
            alert("Không được để trống Email");
        }
        else if (pass === 0 || pass2 === 0) {
            alert("Không được để trông Password")
        }
        else if (!(pass === pass2)) {
            alert("Vui lòng nhập lại pass");
        }
        else if (!isValidEmailAddress(email)) {
            alert("Sai định dạng email");
        }
        else {
            $.post("?controller=admin-user&action=add&ajax=1", {
                userName: userName,
                name: name,
                email: email,
                pass: pass,
                group: group
            })
                .done(function (data) {
                    if (data === "Đăng kí thành công") {
                        alert(data);
                    }
                    else {
                        alert(data);
                    }
                })
        }
    });
});