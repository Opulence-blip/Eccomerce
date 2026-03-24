// Detect pages
const productContainer = document.querySelector(".product-list");
const isProductDetailPage = document.querySelector(".product-detail");
const isCartPage = document.querySelector(".cart");

if (productContainer) {
    displayProducts();
} 
else if (isProductDetailPage) {
    displayProductDetail();
}
else if (isCartPage){
    displayCart();
}

/* =========================
   PRODUCT LIST PAGE
========================= */
function displayProducts() {

    products.forEach(product => {

        const productCard = document.createElement("div");
        productCard.classList.add("product-card");

        productCard.innerHTML = `
            <div class="img-box">
                <img src="${product.colors[0].mainImage}">
            </div>
            <h2 class="title">${product.title}</h2>
            <span class="price">${product.price}</span>
        `;

        productContainer.appendChild(productCard);

        productCard.querySelector(".img-box").addEventListener("click", () => {
            sessionStorage.setItem("selectedProduct", JSON.stringify(product));
            window.location.href = "product-detail.html";
        });

    });
}

/* =========================
   PRODUCT DETAIL PAGE
========================= */
function displayProductDetail() {

    const productData = JSON.parse(sessionStorage.getItem("selectedProduct"));
    if (!productData) return;

    const titleEl = document.querySelector(".title");
    const priceEl = document.querySelector(".price");
    const descriptionEl = document.querySelector(".description");
    const mainImageContainer = document.querySelector(".main-img");
    const thumbnailContainer = document.querySelector(".thumbnail-list");
    const colorContainer = document.querySelector(".color-options");
    const sizeContainer = document.querySelector(".size-options");
    const addToCartBtn = document.querySelector("#add-cart-btn");

    // 🔥 If product comes from DATABASE and has no colors
    if (!productData.colors) {
        productData.colors = [{
            name: "Default",
            mainImage: "uploads/" + productData.image,
            thumbnails: [],
            sizes: ["S", "M", "L", "XL"]
        }];
    }

    let selectedColor = productData.colors[0];
    let selectedSize = selectedColor.sizes[0];

    function updateProductDisplay(colorData) {

        selectedSize = colorData.sizes[0];

        // Main Image
        mainImageContainer.innerHTML = `<img src="${colorData.mainImage}">`;

        // Thumbnails
        if (thumbnailContainer) {
            thumbnailContainer.innerHTML = "";
            const allThumbnails = [colorData.mainImage, ...(colorData.thumbnails || [])];

            allThumbnails.forEach(thumb => {
                const img = document.createElement("img");
                img.src = thumb;

                img.addEventListener("click", () => {
                    mainImageContainer.innerHTML = `<img src="${thumb}">`;
                });

                thumbnailContainer.appendChild(img);
            });
        }

        // Colors
        if (colorContainer) {
            colorContainer.innerHTML = "";

            productData.colors.forEach(color => {

                const img = document.createElement("img");
                img.src = color.mainImage;

                if (color.name === colorData.name) {
                    img.classList.add("selected");
                }

                img.addEventListener("click", () => {
                    selectedColor = color;
                    updateProductDisplay(color);
                });

                colorContainer.appendChild(img);
            });
        }

        // Sizes
        if (sizeContainer) {
            sizeContainer.innerHTML = "";

            colorData.sizes.forEach(size => {

                const btn = document.createElement("button");
                btn.textContent = size;

                btn.addEventListener("click", () => {
                    document.querySelectorAll(".size-options button")
                        .forEach(el => el.classList.remove("selected"));

                    btn.classList.add("selected");
                    selectedSize = size;
                });

                sizeContainer.appendChild(btn);
            });
        }
    }

    titleEl.textContent = productData.title;
    priceEl.textContent = "R" + productData.price;
    descriptionEl.textContent = productData.description;

    updateProductDisplay(selectedColor);

    addToCartBtn.addEventListener("click", () => {
        addToCart(productData, selectedColor, selectedSize);
        alert(productData.title + " added to cart");
    });

    updateCartCount();
}

/* =========================
   ADD TO CART
========================= */
function addToCart(product, color, size) {

    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];

    const colorName = color?.name || "Default";
    const imagePath = color?.mainImage || ("uploads/" + product.image);
    const productPrice = parseFloat(product.price);

    const existingItem = cart.find(item =>
        item.id === product.id &&
        item.color === colorName &&
        item.size === size
    );

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            title: product.title,
            price: productPrice,
            image: imagePath,
            color: colorName,
            size: size || "M",
            quantity: 1
        });
    }

    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
}

/* =========================
   CART PAGE
========================= */
function displayCart() {

    const cartItemsContainer = document.querySelector(".cart-items");
    const subtotalEl = document.querySelector(".subtotal");
    const grandTotalEl = document.querySelector(".grand-total");

    if (!cartItemsContainer) return;

    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    cartItemsContainer.innerHTML = "";

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
        if (subtotalEl) subtotalEl.textContent = "R0";
        if (grandTotalEl) grandTotalEl.textContent = "R0";
        updateCartCount();
        return;
    }

    let subtotal = 0;

    cart.forEach((item, index) => {

        const price = parseFloat(item.price);
        const itemTotal = price * item.quantity;
        subtotal += itemTotal;

        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");

        cartItem.innerHTML = `
            <div class="product">
                <img src="${item.image}" width="80">
                <div class="item-detail">
                    <p>${item.title}</p>
                    <div class="size-color-box">
                        <span class="size">${item.size}</span>
                        <span class="color">${item.color}</span>
                    </div>
                </div>
            </div>
            <span class="price">R${price.toFixed(2)}</span>
            <div class="quantity">
                <input type="number" value="${item.quantity}" min="1" data-index="${index}">
            </div>
            <span class="total-price">R${itemTotal.toFixed(2)}</span>
            <button class="remove" data-index="${index}">
                <i class="ri-close-line"></i>
            </button>
        `;

        cartItemsContainer.appendChild(cartItem);
    });

    if (subtotalEl) subtotalEl.textContent = `R${subtotal.toFixed(2)}`;
    if (grandTotalEl) grandTotalEl.textContent = `R${subtotal.toFixed(2)}`;

    // Remove
    document.querySelectorAll(".remove").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const index = e.currentTarget.dataset.index;
            cart.splice(index, 1);
            sessionStorage.setItem("cart", JSON.stringify(cart));
            displayCart();
        });
    });

    // Quantity change
    document.querySelectorAll(".quantity input").forEach(input => {
        input.addEventListener("change", (e) => {
            const index = e.target.dataset.index;
            const newQty = parseInt(e.target.value);

            if (newQty > 0) {
                cart[index].quantity = newQty;
                sessionStorage.setItem("cart", JSON.stringify(cart));
                displayCart();
            }
        });
    });

    updateCartCount();
}

/* =========================
   CART COUNT
========================= */
function updateCartCount() {
    const cartCountEl = document.querySelector(".cart-item-count");
    const cart = JSON.parse(sessionStorage.getItem("cart")) || [];

    if (cartCountEl) {
        cartCountEl.textContent = cart.length;
    }
}