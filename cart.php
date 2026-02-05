<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart | Novel Coffee</title>
    
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <style>
        /* Reusing your global variables for consistency */
        body {
            /* Note: var(--menu-bg) is defined in style.css */
            background: var(--menu-bg); 
            padding-top: 120px; /* Space for the fixed header */
        }
        .cart-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: var(--white-color);
            border-radius: var(--border-radius-m);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex-grow: 1; /* Allow details to take up more space */
        }
        .cart-item-name {
            font-size: var(--font-size-l);
            font-weight: var(--font-weight-semibold);
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .cart-item-price, .cart-item-subtotal {
            font-size: var(--font-size-n);
            color: var(--dark-color);
        }
        .cart-item-quantity-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 20px;
        }
        .cart-item-quantity {
            width: 45px; /* Slightly smaller input */
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px 0;
            border-radius: 5px;
            font-size: var(--font-size-n);
        }
        .cart-actions {
            display: flex;
            align-items: center;
            gap: 15px; /* Increased gap */
            flex-shrink: 0;
        }
        .remove-btn, .update-btn {
            background: var(--accent-color);
            color: var(--white-color);
            padding: 8px 12px;
            border-radius: var(--border-radius-s);
            font-size: var(--font-size-s);
            transition: background 0.3s;
        }
        .remove-btn:hover { 
            background: #E91E63; /* Pink for remove hover */
        }
        .update-btn { 
            background: var(--secondary-color); 
        }
        .update-btn:hover { 
            background: #c36b13; /* Darker secondary */
        }

        #cart-summary {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--primary-color);
            text-align: right;
        }
        #cart-total-text {
             font-size: var(--font-size-l);
             font-weight: var(--font-weight-bold);
             margin-top: 10px;
        }
        #cart-grand-total {
            font-size: var(--font-size-xl);
            font-weight: var(--font-weight-bold);
            color: var(--primary-color);
        }
        .checkout-btn {
            margin-top: 20px;
            background: var(--primary-color);
            color: var(--white-color);
            padding: 15px 30px;
            border-radius: var(--border-radius-m);
            font-size: var(--font-size-l);
            font-weight: var(--font-weight-semibold);
            display: inline-block;
        }
        .checkout-btn:hover { background: var(--secondary-color); }

        .empty-cart {
            text-align: center;
            padding: 50px 0;
            font-size: 1.2em;
            color: #777;
        }
        /* Responsive adjustments for cart items */
        @media (max-width: 600px) {
            .cart-item {
                flex-direction: column;
                align-items: stretch;
                padding: 15px;
            }
            .cart-item-details {
                margin-bottom: 10px;
            }
            .cart-item-quantity-wrapper {
                justify-content: space-between;
                margin-right: 0;
                margin-bottom: 10px;
            }
            .cart-actions {
                justify-content: space-between;
                gap: 10px;
            }
            .cart-item-subtotal {
                font-weight: var(--font-weight-bold);
            }
        }
    </style>
</head>
<body>

    <header style="position: fixed; top: 0; width: 100%; z-index: 1000; background: var(--accent-color); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
        <nav class="navbar section-content" style="padding: 15px 20px;">
            <a href="index.html" class="logo-box">
                <h2 class="logo-text" style="color: var(--white-color);">Novel Coffee</h2>
            </a>
            <a href="index.html#menu" style="color: var(--white-color); font-weight: var(--font-weight-medium);">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </a>
        </nav>
    </header>

    <div class="cart-container">
        <h2 class="section-title">Your Shopping Cart</h2>
        
        <div id="cart-items-container">
            </div>

        <div id="cart-summary" style="display: none;">
            <p>Subtotal: <span id="cart-subtotal">$0.00</span></p>
            <p id="cart-total-text">Total: <span id="cart-grand-total">$0.00</span></p>
            <a href="checkout.html" class="checkout-btn">Proceed to Checkout</a>
        </div>
        
        <div id="empty-cart-message" class="empty-cart" style="display: none;">
            <i class="fa-solid fa-mug-hot fa-2x"></i>
            <p>Your cart is empty. Time to grab a coffee!</p>
            <a href="index.html#menu" class="checkout-btn">Start Shopping</a>
        </div>
    </div>

    <script>
        // --- Core Utility Functions ---
        // Helper to get cart array from Local Storage
        function getCartItems() {
            const storedCart = localStorage.getItem('novelCafeCart');
            return storedCart ? JSON.parse(storedCart) : [];
        }

        // Helper to save cart array to Local Storage
        function saveCartItems(cart) {
            localStorage.setItem('novelCafeCart', JSON.stringify(cart));
            // Optional: You might want to update the main page's cart count here if the user navigates back
            // updateCartCount();
        }
        
        // Render the cart items from Local Storage
        function renderCart() {
            const cart = getCartItems();
            const cartContainer = document.getElementById('cart-items-container');
            const cartSummary = document.getElementById('cart-summary');
            const emptyMessage = document.getElementById('empty-cart-message');
            cartContainer.innerHTML = '';
            let grandTotal = 0;

            if (cart.length === 0) {
                cartSummary.style.display = 'none';
                emptyMessage.style.display = 'block';
                return;
            }

            emptyMessage.style.display = 'none';
            cartSummary.style.display = 'block';

            cart.forEach(item => {
                // Ensure price is treated as a number
                const price = parseFloat(item.price);
                const subtotal = price * item.quantity;
                grandTotal += subtotal;

                const itemElement = document.createElement('div');
                itemElement.classList.add('cart-item');
                itemElement.setAttribute('data-id', item.id); 

                itemElement.innerHTML = `
                    <div class="cart-item-details">
                        <span class="cart-item-name">${item.name}</span>
                        <span class="cart-item-price">$${price.toFixed(2)} / item</span>
                    </div>
                    
                    <div class="cart-item-quantity-wrapper">
                        <label for="qty-${item.id}" style="font-weight: 500;">Qty:</label>
                        <input type="number" id="qty-${item.id}" class="cart-item-quantity" value="${item.quantity}" min="1">
                        <button class="update-btn" onclick="updateQuantity(${item.id}, document.getElementById('qty-${item.id}').value)">
                            <i class="fa-solid fa-arrows-rotate"></i> Update
                        </button>
                    </div>

                    <div class="cart-actions">
                        <span class="cart-item-subtotal">$${subtotal.toFixed(2)}</span>
                        <button class="remove-btn" onclick="removeItem(${item.id})">
                            <i class="fa-solid fa-trash-can"></i> Remove
                        </button>
                    </div>
                `;
                cartContainer.appendChild(itemElement);
            });

            // Update summary
            document.getElementById('cart-subtotal').textContent = `$${grandTotal.toFixed(2)}`;
            document.getElementById('cart-grand-total').textContent = `$${grandTotal.toFixed(2)}`;
        }

        // Handle item removal
        function removeItem(itemId) {
            let cart = getCartItems();
            cart = cart.filter(item => item.id !== itemId);
            saveCartItems(cart);
            renderCart(); 
        }
        
        // Handle quantity update
        function updateQuantity(itemId, newQuantity) {
            let cart = getCartItems();
            const quantity = parseInt(newQuantity);
            
            if (isNaN(quantity) || quantity < 1) {
                alert("Quantity must be a number greater than 0.");
                renderCart(); // Revert display to current state
                return;
            }

            const itemIndex = cart.findIndex(item => item.id == itemId); // Use == for comparison
            if (itemIndex !== -1) {
                cart[itemIndex].quantity = quantity;
                saveCartItems(cart);
                renderCart(); 
            }
        }

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', renderCart);
    </script>
</body>
</html>