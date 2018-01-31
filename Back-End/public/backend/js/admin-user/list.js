$(function () {
    $('#myTable').DataTable({
        "columnDefs": [
            {"orderable": false, "targets": 4}
        ]
    });
    $(".delete").click(function () {
        event.preventDefault();
        var choice = confirm(this.getAttribute('data-confirm'));
        if (choice) {
            window.location.href = this.getAttribute('href');
        }
    });


});

