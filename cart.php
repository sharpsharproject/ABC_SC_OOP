<?php

    require_once 'src/controllers/ShoppingCart.php';
    include 'components/header.php';

    $shop = new ShoppingCart();

?>

        <div class="container" id="view_cart">
            <div class="row">
                <div class="col-md-9">
                    <div class="text-left">
                        <form action="checkout.php" method="post" onsubmit="return validate()" name="cartForm">

                            <?php

                                if (isset($_SESSION["products"]) && count($_SESSION["products"]) > 0) {

                            ?>

                            <table class="table table-hover table-responsive table-condensed" id="shopping-cart-results">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        $cart_box = '<ul class="cart-products-loaded">';
                                        $total = 0;

                                        foreach ($_SESSION["products"] as $product) {
                                            $product_name = $product["product_name"];
                                            $product_price = $product["product_price"];
                                            $product_image = $product["product_image"];
                                            $product_code = $product["product_code"];
                                            $product_qty = $product["product_qty"];
                                            $subtotal = ($product_price * $product_qty);
                                            $total = ($total + $subtotal);

                                    ?>

                                        <tr>
                                            <td>
                                                <img src="assets/img/products/<?php echo $product_image; ?>" class="img-responsive cart-image" width="100px" height="100px">
                                                &nbsp;&nbsp;<?php echo $product_name; ?>
                                            </td>

                                            <td>
                                                <p class="font-italic font-weight-light price-top">
                                                    <?php echo $shop->db->currency;

                                                        echo sprintf("%01.2f", $product_price);

                                                    ?>
                                                </p>

                                            </td>

                                            <td>
                                                <input type="number" min="1" data-code="<?php echo $product_code; ?>"
                                                       class="form-control cart-quantity cart-top text-center"
                                                       value="<?php echo $product_qty; ?>">
                                            </td>

                                            <td>
                                                <p class="font-italic font-weight-light price-top">
                                                    <?php echo $shop->db->currency;
                                                        echo sprintf("%01.2f", ($product_price * $product_qty)); ?>
                                                </p>
                                            </td>

                                            <td>
                                                <a href="#" class="btn remove-item remove-top"
                                                   data-code="<?php echo $product_code; ?>">
                                                    <i class="fas fa-times fa-2x"></i>
                                                </a>
                                            </td>

                                        </tr>

                                    <?php } ?>

                                    <tfoot>

                                    <br><br>
                                    <tr>
                                        <td>
                                            <a href="index.php" class="btn btn-warning">
                                                <i class="fa fa-angle-left"></i>
                                                Continue Shopping
                                            </a>
                                        </td>

                                        <td colspan="2"></td>

                                        <?php

                                            if (isset($total)) {

                                        ?>

                                            <td class="text-center cart-products-total">
                                                Total: <strong>
                                                    <?php echo $shop->db->currency . sprintf("%01.2f", $total); ?>
                                                </strong>
                                            </td>

                                            <td>
                                                <a href="manage_cart.php?action=clear" class="btn btn-danger btn-block clear">
                                                    Clear cart <i class="fa fa-shopping-cart"></i>
                                                </a>
                                            </td>

                                        <?php } ?>
                                    </tr>
                                    </tfoot>

                                    <?php

                                    } else {
                                        echo "Your Cart is empty";

                                        ?>

                                        <tfoot>
                                        <br><br>

                                        <tr>
                                            <td>
                                                <a href="index.php" class="btn btn-warning">
                                                    <i class="fa fa-angle-left"></i>
                                                    Continue Shopping
                                                </a>
                                            </td>

                                            <td colspan="2"></td>

                                        </tr>
                                        </tfoot>

                                    <?php } ?>

                                    </tbody>
                            </table>

                    </div>
                </div>

                    <div class="col-md-3 payment">
                        <div class="container">
                            <h5 class="text-center">Shipping Info.</h5>

                            <hr>

                            <p>
                                <input type="radio" id="USD0" value="0" name="radioGroup">
                                <label for="USD0">Pick up</label>
                            </p>

                            <p>
                                <input type="radio" id="USD5" value="5" name="radioGroup">
                                <label for="USD5">UPS</label>
                            </p>

                            <input id="inputText" name="ship_address" placeholder="Input shipping address"
                                   class="form-control" type="hidden">

                            <br>

                            <button type="submit" name="submit" class="btn btn-success btn-block">
                                Pay
                                <i class="fa fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<?php

    include('components/footer.php');

?>

<script type="text/javascript">

    // radio buttons
    const showTextBox = () => {
        document.getElementById('inputText').type = "text";
    };

    const hideTextBox = () => {
        document.getElementById('inputText').type = "hidden";
    };

    const upsBtn = document.querySelector('#USD5');
    upsBtn.addEventListener('click', showTextBox);

    const pickUpBtn = document.querySelector('#USD0');
    pickUpBtn.addEventListener('click', hideTextBox);

    const validate = () => {
        let valid = false;
        const x = document.cartForm.radioGroup;
        const y = document.cartForm.ship_address;

        for (let i = 0; i < x.length; i++) {
            if (x[i].checked) {
                valid = true;
                break;
            }
        }

        if (!(valid)) {
            swal("Please select a shipping option!");
            return false;
        } else if (x[1].checked && !(y.value)) {
            swal("Please insert your shipping address!");
            return false;
        } else {
            return true;
        }

    };

</script>