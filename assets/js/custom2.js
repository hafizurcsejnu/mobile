$(document).ready(function() {
    //it was needed for experience search option version 1
    $("#task_area").on("click",".task_id", function(e){
    //$('.task_id').on("click", function(e) {   
        //alert('hi');       
      e.preventDefault();   
        //debugger;           
        var task = $(this).text();  
        var task_id = $(this).attr("id"); 
        //$('#'+ task_id).css("cursor", "not-allowed");
        $('#'+ task_id).css("color", "green");            
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

function job_title_search() {    
    var job_title = $('#searchKeyword').val();
    var soft_skill = $('#soft_skill').val();
    var action_word = $('#searchKeyword2').val();
    console.log(job_title);
    //fetch_customer_data(action_word, soft_skill, job_title);

    $.ajax({
        url:"find_action_word",
        method:'GET',
        data:{job_title:job_title},
        dataType:'json',
        success:function(data)
        {
         //$('#task_area').html(data.table_data);
         //$('#total_records').text(data.total_data);
         console.log(data.total_data);
        }
       })


}

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
