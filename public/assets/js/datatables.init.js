
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


/* Custom filtering function which will search data in column four between two values */

$(document).ready(function() {
    $('#datatable').DataTable( {
       "scrollY": 300,
        "scrollX": true,
         language: {
            paginate: {
                  next: '<i class="fas fa-angle-right"></i>',//'&#8594;', // or '→'
                  previous: '<i class="fas fa-angle-left"></i>',//'&#8592;', // or '←' 
                  first: '<i class="fas fa-angle-double-left"></i>', //'&#8592;', // or '←'
                  last: '<i class="fas fa-angle-double-right"></i>' //'&#8592;' // or '←'
              }
          }
      } );

    

} );