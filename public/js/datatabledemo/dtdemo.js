var contactUrl;
var oTable;
var contactId;
var formvalid;

$(document).ready(function() {
	
	// data table refresh & reload function code
	$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback )
	{
		if ( typeof sNewSource != 'undefined' ){
			oSettings.sAjaxSource = sNewSource;
		}
		this.oApi._fnProcessingDisplay( oSettings, true );
		var that = this;
		 
		oSettings.fnServerData( oSettings.sAjaxSource, null, function(json) {
			/* Clear the old information from the table */
			that.oApi._fnClearTable( oSettings );
			 
			/* Got the data - add it to the table */
			for ( var i=0 ; i<json.aaData.length ; i++ ){
				that.oApi._fnAddData( oSettings, json.aaData[i] );
			}
			 
			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			that.fnDraw( that );
			that.oApi._fnProcessingDisplay( oSettings, false );
			 
			/* Callback user function - for event handlers etc */
			if ( typeof fnCallback == 'function' ){
				fnCallback( oSettings );
			}
		});
	}
	// Script for get Contact List Datatable
	oTable = $('#tbl_productList').dataTable({
		"bJQueryUI": false,
		"bSortClasses": false,
		"bFilter": true,
		"bAutoWidth": false,
		"sScrollY": "100%",
		"sScrollX": "100%",
		"bScrollCollapse": true,
		"bInfo": true,
		"bServerSide": true,
		"sPaginationType": "bootstrap",
		"bRetrieve": true,
		"oLanguage": {
				"sSearch": "Search:",
		},
		"aoColumnDefs": [
                            { "bSearchable": false,"aTargets": [0,3]},
                            { "bSortable": false, "aTargets": [0,3] },
                            { "sWidth": "40px", "aTargets": [ 0 ] },
                ],
		"bProcessing": true,
		"sAjaxSource": "/zend_example/public/datatable/product",
		"aaSorting": [[ 1, "desc" ]],
		"fnServerData": function(sSource, aoData, fnCallback) {
			$.ajax({
					"dataType": 'json',
					"type": "GET",
					"url": sSource,
					"data": aoData,
					"success": fnCallback
			});
		},
		"fnDrawCallback": function (oSettings, json) {
			//Hide last column Header & data. 
			//$("#tbl_productList th:last-child, #tbl_productList td:last-child").hide();
			if(oSettings.fnRecordsTotal() == 0)
			{
				$('.dataTables_empty').show();
				$('.row-fluid').hide();
				$('.odd').html('<td class="dataTables_empty setdef" valign="top" colspan="8">No any product available now.</td>');
			}
			else
			{
				$('.dataTables_empty').hide();
				$('.row-fluid').show();
			}
		},
		"fnInitComplete": function(oSettings, json) { 
		}
	});
	
        //Select And Deselect contacts.
        $('#selectAllContacts').change(function(){
            if($(this).is(":checked"))
                $('.selectContact').prop('checked',true);
            else
                $('.selectContact').prop('checked',false);
        })
});

function selectContact()
{
    nonchecked = 0;
    checked = 0;
    $('.selectContact').each(function(){
        if($(this).is(":checked"))
            checked++;
        else
            nonchecked++;
    });
    
    if(checked == 0)
    {    
        document.getElementById('selectAllContacts').indeterminate = false;
        $('#selectAllContacts').prop('checked',false);
    }
    else if(nonchecked == 0)
    {
        document.getElementById('selectAllContacts').indeterminate = false;
        $('#selectAllContacts').prop('checked',true);
    }
    else
        document.getElementById('selectAllContacts').indeterminate = true;
}


function deleteProduct(id)
{
    if(confirm("Are you sure you want to delete product??"))
    {	
        if(id == null)
            data_string = "&productId=" + encodeURIComponent($('#selectedContact').val());
        else
            data_string = "&productId=" + encodeURIComponent(id);
        $.ajax({
            type: "POST",
            url:"/zend_example/public/datatable/deleteproduct",
            data:data_string,
            success: function(data){
                var json = jQuery.parseJSON(data);
                
                if (json.status == 'success')
                {
                    var Table = $('#tbl_productList').dataTable();
                    Table.fnDraw();
                    
                    //Uncked checkBox in table header
                    document.getElementById('selectAllContacts').indeterminate = false;
                    $('#selectAllContacts').prop('checked',false);
                    
                    $('#buntchActionPopup').addClass('fade-right');
                    $('#buntchActionPopup .close').click();
                    
                    alert('Product Delete Successfully');
                }
                else
                    alert('Something went to wrong. Try again!!!');
            },
            error:function(response){
            }
        });
    }
}

function deleteallproduct()
{
    selectedContId = [];
    $('.selectContact').each(function(){
       if($(this).is(':checked') == true)
           selectedContId.push($(this).val());
    });
    
    if(Object.keys(selectedContId).length > 0)
    {
        $('#selectedContact').val(selectedContId);
        deleteProduct(null);
    }
    else
        alert('Please select product.');
}