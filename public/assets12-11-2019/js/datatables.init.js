/*$(document).ready(function() {
    $("#datatable").DataTable(), $("#datatable-buttons").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'My button',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ],
        lengthChange: !1,
        buttons: ["copy", "excel", "pdf", "colvis"]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});*/

$(document).ready(function() {
    $('#datatable').DataTable( {
        "pagingType": "full_numbers"
    } );
});