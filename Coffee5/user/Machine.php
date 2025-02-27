<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Machines - Coffee Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Cart styles */
        .cart-container {
            position: fixed;
            top: 0;
            right: -350px;
            background: #2d1810;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
            width: 300px;
            height: 100vh;
            z-index: 1000;
            transition: right 0.3s ease-in-out;
            overflow-y: auto;
            color: #fff;
        }

        .cart-container.hidden {
            right: -350px;
        }

        .cart-container:not(.hidden) {
            right: 0;
        }

        .cart-toggle {
            position: fixed;
            top: 90px;
            right: 20px;
            background: #4a3500;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1001;
            transition: right 0.3s ease-in-out;
        }

        .cart-toggle.shifted {
            right: 320px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 100px 0 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .cart-items {
            max-height: 300px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-price {
            color: rgba(255, 255, 255, 0.8);
        }

        .cart-total {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            color: #fff;
        }

        .checkout-btn {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            color: #4a3500;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .checkout-btn:hover {
            background-color: #f0f0f0;
        }

        .remove-item {
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s;
        }

        .remove-item:hover {
            color: #ff6b6b;
        }

        .cart-badge {
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
        }

        .product-card {
            text-align: center;
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .product-card img {
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .product-card h3 {
            color: #4a3500;
            margin: 1rem 0;
        }

        .price {
            color: #4a3500;
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .add-to-cart {
            background-color: #4a3500;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-to-cart:hover {
            background-color: #6b4e00;
        }

        footer {
            background-color: #4a3500;
            color: #ffffff;
            text-align: center;
            padding: 2rem;
            margin-top: 2rem;
        }

        /* Scrollbar styling */
        .cart-items::-webkit-scrollbar {
            width: 8px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #2d1810;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: #4a3500;
        }

        .cart-items::-webkit-scrollbar-thumb:hover {
            background: #6b4e00;
        }
    </style>
</head>
<body>
    <header>
        <?php include 'navbar.php'; ?>
    </header>
    <div class="cart-toggle">
        Cart <span class="cart-badge">0</span>
    </div>

    <!-- Add Cart Container -->
    <div class="cart-container hidden">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <span class="close-cart" style="cursor: pointer;">&times;</span>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-total">
            Total: Rs <span id="cart-total-amount">0</span> NPR
        </div>
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>

    <main>
        <div class="product-container">
            <div class="product-card">
                <img src="../image/distr.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Distributer</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="1">
                    <input type="hidden" name="product_name" value="Distributer">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/scale.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Scale</h3>
                <p class="price">Rs400.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="2">
                    <input type="hidden" name="product_name" value="Scale">
                    <input type="hidden" name="product_price" value="400.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/paper.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>V60 paper</h3>
                <p class="price">Rs350 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="3">
                    <input type="hidden" name="product_name" value="V60 paper">
                    <input type="hidden" name="product_price" value="350">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/pitch.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Pitcher</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="4">
                    <input type="hidden" name="product_name" value="Pitcher">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>
        </div>
    </main>

    <main>
        <div class="product-container">
            <div class="product-card">
                <img src="../image/store.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Storage</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="5">
                    <input type="hidden" name="product_name" value="Storage">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/mach.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Machine</h3>
                <p class="price">Rs400.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="6">
                    <input type="hidden" name="product_name" value="Machine">
                    <input type="hidden" name="product_price" value="400.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/exnedle.jpg" height="300" width="300" alt="Brazil Coffee">
                <h3>Express Needle</h3>
                <p class="price">Rs350 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="7">
                    <input type="hidden" name="product_name" value="Express Needle">
                    <input type="hidden" name="product_price" value="350">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>

            <div class="product-card">
                <img src="../image/filt.avif" height="300" width="300" alt="Brazil Coffee">
                <h3>Filter</h3>
                <p class="price">Rs402.33 NPR</p>
                <form action="cart_functions.php" method="post">
                    <input type="hidden" name="product_id" value="8">
                    <input type="hidden" name="product_name" value="Filter">
                    <input type="hidden" name="product_price" value="402.33">
                    <button class="add-to-cart">Add to cart</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="social-links">
        <a href="https://www.facebook.com/piyush.kapali.9"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/piyush.kapali"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/@piyushkapali3821"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; 2025 Coffee Shop. All rights reserved.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartToggle = document.querySelector('.cart-toggle');
        const cartContainer = document.querySelector('.cart-container');
        const closeCart = document.querySelector('.close-cart');
        const cartBadge = document.querySelector('.cart-badge');
        const cartItems = document.querySelector('.cart-items');
        const cartTotalAmount = document.getElementById('cart-total-amount');

        // Toggle cart visibility
        cartToggle.addEventListener('click', () => {
            cartContainer.classList.toggle('hidden');
            cartToggle.classList.toggle('shifted');
            updateCart(); // Update cart when opened
        });

        closeCart.addEventListener('click', () => {
            cartContainer.classList.add('hidden');
            cartToggle.classList.remove('shifted');
        });

        // Function to update cart
        function updateCart() {
            fetch('get_cart_items.php')
                .then(response => response.json())
                .then(data => {
                    cartItems.innerHTML = '';
                    let total = 0;
                    let itemCount = 0;

                    data.forEach(item => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'cart-item';
                        itemElement.innerHTML = `
                            <div class="cart-item-details">
                                <div>${item.product_name}</div>
                                <div class="cart-item-price">Rs ${item.price} × ${item.quantity}</div>
                            </div>
                            <div class="remove-item" data-id="${item.product_id}">×</div>
                        `;
                        cartItems.appendChild(itemElement);
                        total += item.price * item.quantity;
                        itemCount += item.quantity;
                    });

                    cartTotalAmount.textContent = total.toFixed(2);
                    cartBadge.textContent = itemCount;
                })
                .catch(error => console.error('Error:', error));
        }

        // Update cart when page loads
        updateCart();

        // Add event listener for remove buttons
        cartItems.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item')) {
                const productId = e.target.dataset.id;
                fetch('remove_cart_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCart();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Add event listener for checkout button
        document.querySelector('.checkout-btn').addEventListener('click', () => {
            window.location.href = 'checkout.php';
        });
    });
    </script>
</body>
</html>
