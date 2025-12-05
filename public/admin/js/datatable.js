//Datables
$.extend($.fn.dataTable.defaults, {
    //Uncomment below line to enable save state of datatable.
    //stateSave: true,
    processing: true,
    serverSide: true,
    fixedHeader: true,
    scrollX : true,
    dom:'<"row margin-bottom-20 text-center"<"col-sm-4"l><"col-sm-4"B><"col-sm-4"f> r>tip',          
    lengthMenu      : [[5, 10, 15, 25, 50, 10000], [5, 10, 15, 25, 50, 'All']],
    buttons: [
        {
            extend: 'excel',
            className : 'btn btn-primary table-head-button',
            text : 'Export To Excel',
            exportOptions: {
                columns: ':visible',
            },
            footer : true,
            
        },
        {
            extend: 'colvis',
            className : 'btn btn-primary table-head-button',            
        },
        // 'pdf',
        // 'print',        
    ],
    initComplete: function( settings, json ) {
        $("th.removSorting").removeClass('sorting_desc'); //remove sorting_desc class
        $("th.removSorting").removeClass('sorting_asc'); //remove sorting_desc class
        hideLoader();
    },
    "fnDrawCallback": function( oSettings ) {
        $('table#myTable thead th input[id=check_all]').prop('checked', false);
        $('#check_all').prop('checked', false);
        $('.check_all1').prop('checked', false);
    }, 
});
       
$('#check_all').click(function(){            
    // $('#state_agency_category_id').val('').change();
    if(this.checked){
        $('table#myTable tbody').children().find('input[class=state_agency_agency_id]').map(function(){                           
            return $(this).prop('checked', true);
        }).get();            
    }else{
        $('table#myTable tbody').children().find('input[class=state_agency_agency_id]').map(function(){                           
            return $(this).prop('checked', false);
        }).get();            
    }            
});    


// $('table#myTable').on('click','div.actions',function(){
//     $('#actions').html($(this).html());
//     $('#actions').addClass('action-popup');
//     $('.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody').css('overflow', 'visible');
// })
