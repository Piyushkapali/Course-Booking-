document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productName = button.parentElement.querySelector('h3').innerText;
            alert(`${productName} has been added to your cart!`);
        });
    });

    
});