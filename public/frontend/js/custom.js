
$(document).ready(function() {

    loadCart(); // Load cart when the page loads

    // $(document).on('click', '.increment', function() {
    //     alert('called');
    //     let inputField = $(this).siblings('.product-qty');
    //     let currentValue = parseInt(inputField.val());
    //     let productId = inputField.attr('id').split('-')[1]; // Extract product ID
    //     let csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    //     inputField.val(currentValue + 1);
    
    //     $.ajax({
    //         url: `/update-cart/${productId}`, // Backend route
    //         type: 'POST',
    //         data: {
    //             _token: csrfToken,
    //             quantity: currentValue + 1
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success) {
    //                 $('#header .nav-icon .count-box').text(response.cart.cart_items.length);
    //                 updateCartUI(response.cart);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             alert('Error updating quantity:', error);
    //         }
    //     });
    // });
    
    // $(document).on('click', '.decrement', function() {
    //     let inputField = $(this).siblings('.product-qty');
    //     let currentValue = parseInt(inputField.val());
    //     let productId = inputField.attr('id').split('-')[1]; // Extract product ID
    //     let csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    //     if (currentValue > 1) {
    //         inputField.val(currentValue - 1);
    
    //         $.ajax({
    //             url: `/update-cart/${productId}`,
    //             type: 'POST',
    //             data: {
    //                 _token: csrfToken,
    //                 quantity: currentValue - 1
    //             },
    //             dataType: 'json',
    //             success: function(response) {
    //                 if (response.success) {
    //                     $('#header .nav-icon .count-box').text(response.cart.cart_items.length);
    //                     updateCartUI(response.cart);
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 alert('Error updating quantity:', error);
    //             }
    //         });
    //     }
    // });
    
    $(document).on('click', '#shoppingCart .quantity-selector .increment', function() {
        bring_preloader();
        let inputField = $(this).siblings('.product-qty');
        let currentValue = parseInt(inputField.val());
        let itemId = inputField.attr('id').split('-')[1]; // Extract product ID
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        inputField.val(currentValue + 1);
    
        $.ajax({
            url: `/update-cart-item/${itemId}`, // Backend route
            type: 'POST',
            data: {
                _token: csrfToken,
                quantity: currentValue + 1
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    remove_preloader();
                    updateCartUI(response.cart);
                }
            },
            error: function(xhr, status, error) {
                alert('Error updating quantity:', error);
            }
        });
    });
    
    $(document).on('click', '#shoppingCart .quantity-selector .decrement', function() {
        bring_preloader();
        let inputField = $(this).siblings('.product-qty');
        let currentValue = parseInt(inputField.val());
        let itemId = inputField.attr('id').split('-')[1]; // Extract product ID
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        if (currentValue > 1) {
            inputField.val(currentValue - 1);
    
            $.ajax({
                url: `/update-cart-item/${itemId}`,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    quantity: currentValue - 1
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        remove_preloader();
                        updateCartUI(response.cart);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error updating quantity:', error);
                }
            });
        }
    });

    // Quantity Increment & Decrement
    $(document).on('click', '.card-product .increment', function() {
        let inputField = $(this).siblings('.product-qty');
        let currentValue = parseInt(inputField.val());
        inputField.val(currentValue + 1);
    });

    $(document).on('click', '.card-product .decrement', function() {
        let inputField = $(this).siblings('.product-qty');
        let currentValue = parseInt(inputField.val());
        if (currentValue > 1) {
            inputField.val(currentValue - 1);
        }
    });

    // Add to Cart with Quantity
    $(document).on('click', '.add-cart', function(event) {
        event.preventDefault();

        let productId = $(this).data('id'); // Get product ID
        let qty = $('#qty-' + productId).val(); // Get quantity
        let url = $(this).data('url'); 
        let csrfToken = $('meta[name="csrf-token"]').attr('content'); 

        if(qty <= 0){
            alert("Quantity should not be zero or less!"); 
        }else{
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    quantity: qty // Send quantity
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#header .nav-icon .count-box').text(response.cart.cart_items.length);
                        updateCartUI(response.cart);
                        $('#shoppingCart').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding to cart:', error);
                }
            });
        }
    });

    // Function to fetch cart data and update UI
    function loadCart() {
        $.ajax({
            url: '/cart',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#header .nav-icon .count-box').text(response.cart.cart_items.length);
                    updateCartUI(response.cart);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching cart:', error);
            }
        });
    }

    // Function to update the cart UI dynamically
    function updateCartUI(cart) {
        $('#form-add-note #cart_id').val(cart.id);
        $('#form-add-note #Cart-note').text(cart.note);
        let cartItemsContainer = $('.tf-mini-cart-items');
        cartItemsContainer.empty(); // Clear previous items

        cart.cart_items.forEach(item => {
            let product = item.product;
            let imageUrl = product.image.length ? product.image[0] : 'frontend/images/default-product.jpg';

            let cartItemHTML = `
                <div class="tf-mini-cart-item file-delete">
                    <div class="tf-mini-cart-image">
                        <img class="lazyload" data-src="/storage/${imageUrl}" src="/storage/${imageUrl}" alt="${product.name}">
                    </div>
                    <div class="tf-mini-cart-info flex-grow-1">
                        <div class="mb_12 d-flex align-items-center justify-content-between flex-wrap gap-12">
                            <div class="text-title">
                                <a href="/product/${product.slug}" class="link text-line-clamp-1">${product.name}</a>
                            </div>
                            <div class="text-button tf-btn-remove remove" data-id="${item.id}">Remove</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-12">
                            <div class="text-button d-flex">
                                <div class="quantity-selector d-flex btn-main-product" style="height:2rem">
                                    <button class="decrement">-</button>
                                    <input type="number" disabled="true" class="product-qty" id="qty-${item.id}" value="${item.quantity}" min="1">
                                    <button class="increment">+</button>
                                </div>
                                <span class="cart-price my-auto" style="margin-left: 5px"> X $${item.price}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            cartItemsContainer.append(cartItemHTML);
        });

        // Update Subtotal
        $('.tf-totals-total-value').text(`$${cart.total_amount}`);

        // Update Proof Display
        let proofContainer = $('#proof-container');
        proofContainer.empty(); // Clear previous proof

        if (cart.proof) {
            let proofs = JSON.parse(cart.proof); // Parse JSON array of proof file paths
            let proofHTML = `<div class="mb-2"><label>Current Price Proof:</label><br>`;

            proofs.forEach(proof => {
                let proofUrl = `/storage/${proof}`;
                let fileExtension = proof.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                    proofHTML += `<a href="${proofUrl}" target="_blank">
                                    <img src="${proofUrl}" alt="Proof" class="img-thumbnail" style="max-width: 150px; margin-right: 10px;">
                                </a>`;
                } else {
                    proofHTML += `<a href="${proofUrl}" target="_blank" class="btn btn-sm btn-info" style="margin-right: 10px;">View Proof</a>`;
                }
            });

            proofHTML += `</div>`;
            proofContainer.append(proofHTML);
        }
    }

    // Handle remove item event
    $(document).on('click', '.tf-btn-remove', function() {
        let itemId = $(this).data('id');

        $.ajax({
            url: `/cart/remove`, // Define cart item removal endpoint
            type: 'POST',
            data: {
                 cart_item_id : itemId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#header .nav-icon .count-box').text(response.cart.cart_items.length);
                    updateCartUI(response.cart);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error removing item:', error);
            }
        });
    });
});