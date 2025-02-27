document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartToggle = document.querySelector('.cart-toggle');
    const cartContainer = document.querySelector('.cart-container');
    const closeCart = document.querySelector('.close-cart');
    const cartItems = document.querySelector('.cart-items');
    const cartTotalAmount = document.getElementById('cart-total-amount');

addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.parentElement.getAttribute('data-id'); // Assuming you have a data-id attribute
        const productName = button.parentElement.querySelector('h3').innerText;
        const productPrice = button.parentElement.querySelector('.price').innerText; // Adjust as necessary

        // Send AJAX request to add to cart
        fetch('cart_functions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                product_name: productName,
                product_price: productPrice,
            }),
        })
        .then(response => response.json())
        .then(data => {
            alert(`${productName} has been added to your cart!`);
            updateCart(); // Update the cart display
        })
        .catch(error => console.error('Error:', error));
    });
});
    // Function to update cart
    function updateCart() {
        console.log("Updating cart..."); // Log to confirm function execution
        fetch('get_cart_items.php')
            .then(response => response.json())
            .then(data => {
                console.log("Cart items fetched:", data); // Log fetched cart items
                cartItems.innerHTML = ''; // Clear existing items
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

    // Toggle cart visibility
    cartToggle.addEventListener('click', () => {
        cartContainer.classList.toggle('hidden');
        updateCart(); // Update cart when opened
    });

    closeCart.addEventListener('click', () => {
        cartContainer.classList.add('hidden');
    });
});
