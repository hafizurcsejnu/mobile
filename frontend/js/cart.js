

$(document).ready(function(){
    // $('.addToCart').click(function () {
    $(document).on('click','.addToCart',function () {
        var id = $(this).data('id');
        //console.log(id);
        var url = window.location.href;
        var domain = url.match(/^https:\/\/[^/]+/);
        var qty = 1;
        
        $.ajax({
            // url: domain+"/shop-subcategory/add-to-cart",
            url: domain+"/add-to-cart",
            data:{
                prod_id: id,
                qty:qty,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            type: 'POST',
            success: function (data) {
                //console.log(data);
                if (data){                                       
                    $(".number-cart").html(data);
                    $("#atc"+ id).html("<span>Item added!</span>");
                }
               
            //window.location.href = "https://ready3dmodels.com/cart";
            }
        });
    });
   
    $(document).on('click','.add-to-cart',function () {
        var id = $(this).data('id');
        console.log(id);
        var qty = 1;
        
        $.ajax({
            url: "https://ready3dmodels.com/3dmodels/add-to-cart",
            data:{
                prod_id: id,
                qty:qty,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            type: 'POST',
            success: function (data) {
                console.log(data);
                if (data){                                       
                    $(".number-cart").html(data);
                    //$(".add-to-cart-btn").html("Item added");
                }              
            
            }
        });
    });

    $("#cart").click(function(){
        window.location.href="/cart";
    })

    $(".dec_qty").click(function () {
        var id = $(this).data('id');
        var item_total = parseInt($(".item_total_" + id).html());
        var unit_total = parseInt($(".unit_price_" + id).html());
        var new_total = item_total - unit_total;
        
        if (parseInt($(this).parent().find('.qty').val()) > 1) {
            $(".item_total_" + id).html(new_total);
            $(this).parent().find('.qty').val(parseInt($(this).parent().find('.qty').val()) - 1);
            var qty = $(this).parent().find('.qty').val();
            $.ajax({
                url: "product/update-cart",
                data: {
                    id: id,
                    quantity: qty,
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                type: 'POST',
                success: function (data) {
                    $.get("get-cart-total?action=dec&id=" + id, function (total) {
                        $('.sub-total').html(total);
                        $('.total').html(total);
                        $('.payable-total').html(total);
                    });
                }
            });
        } else {
            if ($(this).parent().find('div.error').html()!="") {

            }
            else {
                $(this).parent().find(".error").html("Quantity Cannot be 0");
                
            }
        }
    });

    $(".inc_qty").click(function () {
        var id = $(this).data('id');
        var item_total = parseInt($('.item_total_' + id).html());
        var unit_total = parseInt($(".unit_price_" + id).html());
        var new_total = unit_total + item_total;
        $(".item_total_" + id).html(new_total);
        if (parseInt($(this).parent().find('.qty').val()) >= 1) {

            $(this).parent().find('.qty').val(parseInt($(this).parent().find('.qty').val())+1);
            
            var qty = $(this).parent().find('.qty').val();
            $.ajax({
                url: "product/update-cart",
                data:{
                    id:id,
                    quantity:qty,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                type: 'POST',
                success: function ( data ) {
                    $.get("get-cart-total?action=inc", function (total) {
                        $('.sub-total').html(total);
                        $('.total').html(total);
                        $('.payable-total').html(total);
                    });
                }
            });
        } else {
            $(this).parent().append("<div class='text-danger'>Quantiy Cannot be 0</div>")
        }
    });

    $(".remove").click(function () {
        var id = $(this).data('id');
        $.ajax({
            url: "product/remove-cart-item",
            data:{
                id:id,
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
            type: 'POST',
            success: function ( data ) {
                $("#" + id).remove();
                $.get("get-cart-total?action=rem&id="+id, function (total) {
                    console.log(total);
                    $('.sub-total').html(total);
                    $('.total').html(total);
                    $('.payable-total').html(total);
                });
            }
        });
    });
});