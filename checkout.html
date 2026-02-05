<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | Novel Coffee</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        :root { --primary: #6F4E37; --cream: #F9F5F2; --aba-blue: #005a9c; --ac-blue: #0b4a99; }
        body { background: var(--cream); padding-top: 100px; font-family: 'Segoe UI', sans-serif; }
        .checkout-container { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 30px; padding: 20px; }
        .checkout-box { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        
        /* Form Styling */
        h3 { color: var(--primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; }

        /* Payment Icons Grid */
        .payment-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
        .pay-option input { display: none; }
        .pay-card { 
            padding: 15px; border: 2px solid #f0f0f0; border-radius: 15px; 
            text-align: center; cursor: pointer; transition: 0.3s; 
            background: #fff; display: flex; flex-direction: column; align-items: center; gap: 8px;
        }
        .pay-card img { width: 40px; height: 40px; object-fit: contain; border-radius: 8px; }
        .pay-card span { font-size: 0.8rem; font-weight: bold; }
        
        .pay-option input:checked + .pay-card { 
            border-color: var(--primary); background: #faf7f2; transform: translateY(-3px); 
            box-shadow: 0 5px 15px rgba(111, 78, 55, 0.1);
        }

        /* QR and Info Display */
        .method-info-display { background: #fdfaf8; padding: 25px; border-radius: 15px; border: 1px dashed #ddd; text-align: center; }
        .qr-frame { width: 200px; margin: 0 auto; border: 4px solid #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .qr-frame img { width: 100%; display: block; }

        /* Summary Card */
        .summary-card { background: var(--primary); color: white; padding: 30px; border-radius: 20px; position: sticky; top: 120px; }
        .total-row { border-top: 1px solid rgba(255,255,255,0.2); margin-top: 20px; padding-top: 20px; display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: bold; }
        .confirm-btn { width: 100%; background: #FFD700; color: #4B3621; padding: 18px; border: none; border-radius: 12px; font-size: 1.2rem; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s; }
        .confirm-btn:hover { background: #ffea00; transform: translateY(-2px); }

        @media (max-width: 850px) { .checkout-container { grid-template-columns: 1fr; } .summary-card { position: static; } }
    </style>
</head>
<body>

    <header style="position: fixed; top: 0; width: 100%; z-index: 1000; background: var(--primary); padding: 15px 0;">
        <nav style="max-width: 1100px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; color: white;">
            <a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">NOVEL COFFEE</a>
            <a href="cart.html" style="color: white; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Back to Cart</a>
        </nav>
    </header>

    <div class="checkout-container">
        <div class="form-side">
            <form id="checkout-form">
                <div class="checkout-box" style="margin-bottom: 20px;">
                    <h3><i class="fa-solid fa-truck-fast"></i> Delivery Information</h3>
                    <div class="form-group">
                        <label>Receiver Name</label>
                        <input type="text" id="cust-name" required placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label>Contact Phone / Email</label>
                        <input type="tel" id="cust-phone" required placeholder="Phone Number or Email">
                    </div>
                    <div class="form-group">
                        <label>Delivery Address / Location Link</label>
                        <input type="text" id="cust-address" required placeholder="Street Number, Landmark, or Map Link">
                    </div>
                </div>

                <div class="checkout-box">
                    <h3><i class="fa-solid fa-wallet"></i> Payment Method</h3>
                    <div class="payment-grid">
                        <label class="pay-option">
                            <input type="radio" name="pay-method" value="ABA" checked onchange="updateView('aba')">
                            <div class="pay-card">
                                <img src="data:image/png;base64,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" alt="ABA">
                                <span>ABA PAY</span>
                            </div>
                        </label>
                        <label class="pay-option">
                            <input type="radio" name="pay-method" value="ACLEDA" onchange="updateView('acleda')">
                            <div class="pay-card">
                                <img src="data:image/jpeg;base64,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" alt="AC">
                                <span>ACLEDA</span>
                            </div>
                        </label>
                        <label class="pay-option">
                            <input type="radio" name="pay-method" value="Cash on Delivery" onchange="updateView('cod')">
                            <div class="pay-card">
                                <i class="fa-solid fa-handshake" style="font-size: 35px; color: #666; height: 40px;"></i>
                                <span>CASH</span>
                            </div>
                        </label>
                    </div>

                    <div class="method-info-display" id="payment-view">
                        <div id="aba-info">
                            <p style="margin-top:0;">Scan to Pay for: <b>Novel Cafe</b></p>
                            <div class="qr-frame">
                                <img src="images/qr.jpg" alt="TOUCH SOKLENG QR">
                            </div>
                            <p style="font-size: 0.8rem; color: #888; margin-top: 10px;">Please transfer the exact amount shown in summary.</p>
                        </div>
                        <div id="acleda-info" style="display:none;">
                            <p><strong>ACLEDA Bank Transfer</strong></p>
                            <div style="background:#fff; padding: 15px; border-radius:10px; border: 1px solid #eee;">
                                <p style="margin: 5px 0;">Account Name: <b>NOVEL COFFEE</b></p>
                                <p style="margin: 5px 0;">Account Number: <b>007 411 013</b></p>
                            </div>
                            <p style="font-size: 0.8rem; color: #cc0000; margin-top:10px;">* Please attach screenshot when driver arrives.</p>
                        </div>
                        <div id="cod-info" style="display:none;">
                            <p><strong>Pay on Arrival</strong></p>
                            <p style="font-size: 0.9rem; color: #666;">Our driver will collect the cash when they deliver your fresh coffee! 🛵</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="summary-side">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div id="item-list"></div>
                <div class="total-row">
                    <span>Total</span>
                    <span id="grand-total">$0.00</span>
                </div>
                <button type="submit" form="checkout-form" class="confirm-btn">Confirm Order</button>
            </div>
        </div>
    </div>

    <script>
        // Toggle payment details
        function updateView(method) {
            document.getElementById('aba-info').style.display = method === 'aba' ? 'block' : 'none';
            document.getElementById('acleda-info').style.display = method === 'acleda' ? 'block' : 'none';
            document.getElementById('cod-info').style.display = method === 'cod' ? 'block' : 'none';
        }

        // Load cart items
        function loadSummary() {
            const cart = JSON.parse(localStorage.getItem('novelCafeCart')) || [];
            const container = document.getElementById('item-list');
            let total = 0;
            if(cart.length === 0) { window.location.href = 'index.html'; return; }
            
            cart.forEach(item => {
                const sub = item.price * item.quantity;
                total += sub;
                container.innerHTML += `<div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:0.95rem;">
                    <span>${item.name} x${item.quantity}</span>
                    <span>$${sub.toFixed(2)}</span>
                </div>`;
            });
            document.getElementById('grand-total').innerText = `$${total.toFixed(2)}`;
        }

        // Form Submission
        document.getElementById('checkout-form').onsubmit = function(e) {
            e.preventDefault();
            const orderInfo = {
                name: document.getElementById('cust-name').value,
                phone: document.getElementById('cust-phone').value,
                address: document.getElementById('cust-address').value,
                method: document.querySelector('input[name="pay-method"]:checked').value,
                total: document.getElementById('grand-total').innerText,
                orderID: 'NVL-' + Math.floor(Math.random() * 900000 + 100000)
            };
            localStorage.setItem('lastOrder', JSON.stringify(orderInfo));
            localStorage.removeItem('novelCafeCart');
            window.location.href = 'order-success.html';
        };

        window.onload = loadSummary;
    </script>
</body>
</html>