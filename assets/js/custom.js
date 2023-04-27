$(document).ready(function() {

    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-product').attr('href','/delete-product/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-category').attr('href','/delete_product_category/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal_sub .delete-sub-category').attr('href','/delete_product_sub_category/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-collection').attr('href','/delete-collection/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-datalookup').attr('href','/delete_data_lookup/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-coupon').attr('href','/delete_coupon/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-page').attr('href','/delete-page/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-store').attr('href','/delete-store/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-customer').attr('href','/delete-customer/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-company').attr('href','/delete-company/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-bank').attr('href','/delete-bank/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-user').attr('href','/delete-user/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-cargo-invoice').attr('href','/delete-cargo-invoice/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-invoice').attr('href','/delete-invoice/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-purchase').attr('href','/delete-purchase/'+id);
    });
    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-expense').attr('href','/delete-expense/'+id);
    });

    $(document).on('click','.delete-btn',function(){
        var id = $(this).data('id');
        $('#confirm_delete_modal .delete-employee').attr('href','/delete-employee/'+id);
    });
  
  










    //$("#task_area").on("click",".task_id", function(e){
    $('.task_id').on("click", function(e) {          
      e.preventDefault();   
        //debugger;           
        var task = $(this).text();  
        var task_id = $(this).attr("id"); 
        //$('#'+ task_id).css("cursor", "not-allowed");
        $('#'+ task_id).css("color", "grey");            
        //$('#'+ task_id).off('click');

                   
        var task = $.trim(task);
        var task_li = "<li>"+task+"</li>";
        var description = $('#summernote').summernote('code');
        description = $.trim(description);
        //console.log(description);
       
        var new_des = description+task_li;
        $('#summernote').summernote('code', new_des);

        var description = $('#summernote ul').append(task_li);
    });

    $("#submitBtn").click(function(){
      var discription = $("#description").html();
    //   $("#descForm").append("<input type='hidden' name='description' value='"+discription+"'>");
      $("#descForm").submit();
    });

   
    
});

function search() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("searchKeyword");
    filter = input.value.toUpperCase();
    li = document.getElementsByClassName("task_id");
    for (i = 0; i < li.length; i++) {
        a = li[i];
        //alert(b);
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
function search2() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("searchKeyword2");
    filter = input.value.toUpperCase();
    li = document.getElementsByClassName("task_id");
    for (i = 0; i < li.length; i++) {
        a = li[i];
        //alert(b);
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
 

setTimeout(function() {
    $('.flash-message').fadeOut('fast');
}, 5000);



$(document).ready(function() {
    $('.select2_class').select2();
});

function confirmDelete() {
    return confirm('Are you sure you want to delete this item?');
}
