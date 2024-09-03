<?php

//  $id=wc_getuser(2); 
// print_r($id); 
// die(); 
?>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->

<style>
th {
    text-align: center;
}

td {
    text-align: center;
}


span.total {
    float: left;
    margin-left: 5%;
}

h5.total_heading {
    float: left;
}

button.btn.btn-danger.request {
    margin-left: 78%;
}

img#empty_cart {
    margin-left: 27%;
}


.alert.alert-success.message {
    width: 24%;
    height: 60px;
    float: right;
    display: none;
}
.alert.alert-danger.error {
    width: 24%;
    height: 60px;
    float: right;
    display: none;
    position:relative; 
}
</style>

<script>
jQuery(document).ready(function() {


    // jQuery("#condition").on("click", function() {

    //     var link = document.createElement('a');
    //     link.href = "/wp-content/themes/astra-child/condition/Instructions Selling to Pokemagic.pdf";
    //     link.download = 'Pokemagic.pdf';
    //     link.dispatchEvent(new MouseEvent('click'));

    // });


    function reload() {
        location.reload();


    }

    function hide_alert() {
        // jQuery(".error").hide();

        window.location.href = "<?php echo esc_url(home_url('/my-account/check-request')); ?>";
    }

    function hide_error_alert() {
        jQuery(".error").hide();
    }

    jQuery("#cart").on("click", function() {
        var condition = jQuery("#condition").prop("checked");
        if (condition) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: "send_request"
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status == true) {
                        jQuery(".message").show();
                        jQuery(".message").html(data.message);
                        setTimeout(hide_alert, 2200);
                    }

                }
            });
        } else {
        
                        jQuery(".error").show();
                        jQuery(".error").html("Select Terms and condition");
                        setTimeout(hide_error_alert, 2200);
                        
        }
    });

    jQuery(document).on("click", ".remove_item", function() {
        var id = jQuery(this).data('id');
        jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: "remove_cart",
                'id': id
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status == true) {
                    jQuery(".message").show();
                    jQuery(".message").html(data.message);
                    setTimeout(reload, 2200);
                }

            }
        });
    });

});
</script>


<?php
/**
 * Template Name: Add to card 
 */
 
 get_header();
?>
<div class="alert alert-success message" role="alert">

</div>
<div class="alert alert-danger error" role="alert">

</div>

<?php
 $data=wc_get_cart(); 


if(!empty($data))
{

?>
<div class="cart-section">
    <div class="container">
        <div class="details cart-details">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Total </th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                foreach($data['result'] as $product)
                {
          	?>
                    <tr>
                        <td><?php echo $product->product_name ?></td>
                        <td><?php echo $product->currency.$formatted_number = number_format($product->price, 2); ?></td>
                        <td><?php echo $product->quantity ?></td>
                        <td><?php echo $product->currency.$total = number_format($product->total, 2);  ?></td>
                        <td><button type="button" class="btn btn-danger remove_item"
                                data-id=<?php echo $product->id ?>>Remove</button> </td>
                    </tr>
                    <?php
             }
            ?>
                </tbody>
            </table>
        </div>
        <div class="price_total">
            <div class="price_total_box">
                <lable> <input type="checkbox" id="condition">  <a href="/wp-content/themes/astra-child/condition/Instructions Selling to Pokemagic.pdf" style="color:blue">I Confirm  Terms and Conditions.</a> </label>
                    <h5 class="total_heading">Cart Totals</h5>
                    <div class="total-price">
                        <span>Total</span>
                        <span class="total"><?php echo $data['result'][0]->currency.$data['total_result']?></span>
                    </div>
                    <div class="checkout-btns">
                        <button type="button" class="btn  request" id="cart">Request</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php
}
else
{
   echo '
  <img src="https://pokemagic-sell.hsdevbox.com/wp-content/uploads/sites/3/2023/11/empty_cart.png" id="empty_cart">
';
}
get_footer();
?>