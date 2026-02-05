document.addEventListener('DOMContentLoaded', () => {

    // --- Configuration & Elements ---
    const CART_STORAGE_KEY = 'novelCafeCart'; // MUST match the key used in cart.php
    const HEADER_OFFSET = 80; // Used for smooth scrolling offset
    
    // --- DOM Elements ---
    const menu = document.querySelector('.nav-menu'); 
    const menuOpenBtn = document.getElementById('menu-open-button');
    const menuCloseBtn = document.getElementById('menu-close-button');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // --- Cart & Notification Elements ---
    const cartCountElement = document.getElementById('cart-count'); // Total items (count = unique items * quantity)
    const notificationElement = document.getElementById('cart-notification');
    const notificationTextElement = document.getElementById('notification-text');

    // --- Modal Elements (For Cart Modal) ---
    const cartModal = document.getElementById('cart-modal');
    const cartBoxButton = document.querySelector('.cart-box');
    const modalCloseButton = document.querySelector('.modal .close-button');
    const modalCartItemsContainer = document.getElementById('modal-cart-items');
    const modalTotalElement = document.getElementById('modal-grand-total');

    let cart = []; // The actual cart array: [{ id: 1, name: '...', price: 5.00, quantity: 2 }, ...]


    // ==============================================
    // 1. Local Storage & Cart Initialization
    // ==============================================

    /**
     * Helper: Generates a unique numeric ID (timestamp based) for new items.
     */
    function generateUniqueId() {
        return Date.now();
    }

    /**
     * Loads cart data from Local Storage, updates the global 'cart' array,
     * and refreshes the cart count display.
     */
    function loadCart() {
        const storedCart = localStorage.getItem(CART_STORAGE_KEY);
        if (storedCart) {
            try {
                cart = JSON.parse(storedCart);
            } catch (error) {
                console.error("Error loading cart from Local Storage:", error);
                cart = []; 
            }
        }
        updateCartCountDisplay();
    }

    /**
     * Saves the current 'cart' array to Local Storage.
     */
    function saveCart() {
        try {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
            updateCartCountDisplay();
        } catch (error) {
            console.error("Error saving cart to Local Storage:", error);
        }
    }
    
    /**
     * Calculates total item quantity and updates the header count display.
     */
    function updateCartCountDisplay() {
        if (cartCountElement) {
            // Count the total number of items (unique item quantity sum)
            const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCountElement.textContent = totalCount;
        }
    }

    // Initialize cart on page load
    loadCart(); 


    // ==============================================
    // 2. Mobile Menu Toggle Logic
    // ==============================================

    // Open menu
    if (menuOpenBtn && menu) {
        menuOpenBtn.addEventListener('click', () => {
            menu.classList.add('active'); 
        });
    }

    // Close menu
    if (menuCloseBtn && menu) {
        menuCloseBtn.addEventListener('click', () => {
            menu.classList.remove('active'); 
        });
    }

    // ==============================================
    // 3. Navigation & Smooth Scroll Logic
    // ==============================================

    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            // 1. Close mobile menu
            if (menu && menu.classList.contains('active')) {
                 menu.classList.remove('active');
            }
            
            // 2. Handle smooth scrolling
            if (targetElement) {
                event.preventDefault(); 
                
                // Calculate scroll position, accounting for the fixed header height
                const targetPosition = targetElement.offsetTop - HEADER_OFFSET;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ==============================================
    // 4. Cart Logic (Public Functions)
    // ==============================================
    
    /**
     * Displays a sliding toast notification.
     */
    function showNotification(itemName) {
        if (notificationElement && notificationTextElement) {
            notificationTextElement.textContent = `${itemName} added to cart!`;
            notificationElement.classList.add('visible');

            setTimeout(() => {
                notificationElement.classList.remove('visible');
            }, 3000); 
        }
    }

    /**
     * Adds an item to the cart, handling quantity updates if the item exists.
     * @param {string} productName - The name of the item.
     * @param {number} price - The price of the item.
     * @param {number} quantity - The quantity to add (default is 1).
     */
    window.addToCart = function(productName, price, quantity = 1) {
        const itemPrice = parseFloat(price);
        
        // Check if item already exists in cart (using name as a temporary unique identifier for menu page)
        const existingItem = cart.find(item => item.name === productName); 

        if (existingItem) {
            // If item exists, just increment quantity
            existingItem.quantity += quantity;
        } else {
            // If item is new, add it with a unique ID
            const newItem = {
                id: generateUniqueId(),
                name: productName,
                price: itemPrice,
                quantity: quantity
            };
            cart.push(newItem);
        }
        
        saveCart();
        
        // 1. Show the visual confirmation (toast)
        showNotification(productName);
        
        // 2. Immediately open the cart modal to show the product.
        if (cartModal) {
            renderModalCart(); // Ensure the modal content is up to date
            cartModal.style.display = 'block'; // Show the modal
        }
    };

    /**
     * Handler for the Buy Now button: adds to cart and redirects.
     * NOTE: This is attached to the global scope to be called inline from HTML.
     */
    window.buyNowRedirect = function(productName, price) {
        window.addToCart(productName, price, 1);
        
        // Wait a short time for the Local Storage save to complete before redirecting
        setTimeout(() => {
            window.location.href = 'cart.php';
        }, 500); 
    };

    // ==============================================
    // 5. Cart Modal Logic
    // ==============================================

    /**
     * Populates the modal with current cart items.
     */
    function renderModalCart() {
        modalCartItemsContainer.innerHTML = '';
        let modalGrandTotal = 0;

        if (cart.length === 0) {
            modalCartItemsContainer.innerHTML = '<p style="text-align: center; color: #777;">Your cart is empty.</p>';
            modalTotalElement.textContent = '$0.00';
            return;
        }

        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            modalGrandTotal += subtotal;

            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-modal-item');
            itemElement.innerHTML = `
                <span>${item.name}</span>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button onclick="updateModalQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateModalQuantity(${item.id}, ${item.quantity + 1})">+</button>
                </div>
                <span>$${subtotal.toFixed(2)}</span>
                <button onclick="removeItemFromModal(${item.id})" style="margin-left: 10px;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            `;
            modalCartItemsContainer.appendChild(itemElement);
        });

        modalTotalElement.textContent = `$${modalGrandTotal.toFixed(2)}`;
    }

    /**
     * Updates item quantity directly from the modal.
     */
    window.updateModalQuantity = function(itemId, newQuantity) {
        const itemIndex = cart.findIndex(item => item.id == itemId);

        if (itemIndex !== -1) {
            if (newQuantity < 1) {
                // If new quantity is 0 or less, remove the item
                removeItemFromModal(itemId);
            } else {
                cart[itemIndex].quantity = newQuantity;
                saveCart();
                renderModalCart(); // Refresh the modal display
            }
        }
    }
    
    /**
     * Removes an item directly from the modal.
     */
    window.removeItemFromModal = function(itemId) {
        cart = cart.filter(item => item.id != itemId);
        saveCart();
        renderModalCart(); // Refresh the modal display
    }


    // Modal Event Listeners (Existing logic remains to allow manual opening via cart icon)
    if (cartBoxButton && cartModal) {
        cartBoxButton.addEventListener('click', () => {
            renderModalCart();
            cartModal.style.display = 'block';
        });
    }

    if (modalCloseButton && cartModal) {
        modalCloseButton.addEventListener('click', () => {
            cartModal.style.display = 'none';
        });
    }

    // Close modal when clicking anywhere outside of it
    window.addEventListener('click', (event) => {
        if (event.target === cartModal) {
            cartModal.style.display = 'none';
        }
    });
    //  Swiper Initialization
    if (typeof Swiper !== 'undefined' && document.querySelector('.slider-wrapper')) {
        new Swiper('.slider-wrapper', {
            direction: 'horizontal',
            loop: true,
            slidesPerView: 3, 
            spaceBetween: 30, 
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            speed: 600,
            breakpoints: {
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                }
            }
        });
    }

    //login 
    
});