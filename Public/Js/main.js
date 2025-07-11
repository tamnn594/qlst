// Sample products data
let products = [
    {
        id: 1,
        name: "Gạo ST24 - Túi 5kg",
        category: "food",
        price: 125000,
        image: "https://tse4.mm.bing.net/th?id=OIP.88bqk-xrd17cRtx9n3R1OwHaE8&pid=Api&P=0&h=220",
        description: "Gạo thơm ngon, chất lượng cao"
    },
    {
        id: 2,
        name: "Coca Cola - Lon 330ml",
        category: "drink",
        price: 15000,
        image: "https://tse1.mm.bing.net/th?id=OIP._pNu37xcrS1shNDyrT6NlAHaE8&pid=Api&P=0&h=220",
        description: "Nước ngọt có gas, vị cola truyền thống"
    },
    {
        id: 3,
        name: "Bánh quy Oreo",
        category: "snack",
        price: 25000,
        image: "https://cdn.tgdd.vn/2021/06/CookProduct/1(3)-1200x676-1.jpg",
        description: "Bánh quy kem socola thơm ngon"
    },
    {
        id: 4,
        name: "Nước rửa chén Sunlight",
        category: "household",
        price: 45000,
        image: "https://khoe.online/wp-content/uploads/2022/05/gia-nuoc-rua-chen-sunlight.jpg",
        description: "Nước rửa chén an toàn, khử mùi hiệu quả"
    },
    {
        id: 5,
        name: "Sữa tươi TH True Milk",
        category: "drink",
        price: 28000,
        image: "https://ktmt.vnmediacdn.com/images/2022/03/29/13-1648564494-cover-1.jpg",
        description: "Sữa tươi nguyên chất, không đường"
    },
    {
        id: 6,
        name: "Mì tôm Hảo Hảo",
        category: "food",
        price: 4500,
        image: "https://cf.shopee.vn/file/422a048d7de0560d93d5b6b3163e9ff0",
        description: "Mì tôm chua cay truyền thống"
    },
    {
        id: 7,
        name: "Trà xanh Không Độ",
        category: "drink",
        price: 10000,
        image: "https://tse4.mm.bing.net/th?id=OIP.9_vafZVoNv4yivdw-iBFpwHaFj&pid=Api&P=0&h=220",
        description: "Nước trà xanh thanh mát"
    },
    {
        id: 8,
        name: "Khăn giấy Bless You",
        category: "household",
        price: 20000,
        image: "https://tse1.mm.bing.net/th?id=OIP.jBq1oo0MfAFcs9IK3N3yPQHaFj&pid=Api&P=0&h=220",
        description: "Khăn giấy mềm mịn, dùng đa năng"
    },
    {
        id: 9,
        name: "Snack khoai tây Lay's",
        category: "snack",
        price: 18000,
        image: "https://cdn.tgdd.vn/Files/2021/09/29/1386443/snack-lays-vi-nao-ngon-nhat-202109290914056051.jpg",
        description: "Snack khoai giòn rụm, vị tự nhiên"
    },
    {
        id: 10,
        name: "Sữa chua Vinamilk",
        category: "drink",
        price: 6000,
        image: "https://www.vinamilk.com.vn/sua-chua-vinamilk/wp-content/uploads/2023/03/2023_s7-VNM_BQNK_VideoThumbnail_MO-640x480@2x-1.jpg",
        description: "Sữa chua trắng lên men tự nhiên"
    }
];

let cart = [];
let currentFilter = 'all';

// Initialize the page
function init() {
    renderProducts();
    updateCartCount();
    startCountdown();
}

// Render products
function renderProducts() {
    const grid = document.getElementById('productsGrid');
    const filteredProducts = currentFilter === 'all' 
        ? products 
        : products.filter(p => p.category === currentFilter);
    
    grid.innerHTML = filteredProducts.map(product => `
        <div class="product-card">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <h3>${product.name}</h3>
                <div class="product-category">${getCategoryName(product.category)}</div>
                <div class="product-price">${formatPrice(product.price)}</div>
                <div class="product-actions">
                    <button class="btn btn-primary" onclick="addToCart(${product.id})">🛒 Thêm vào giỏ</button>
                    <button class="btn btn-secondary" onclick="deleteProduct(${product.id})">🗑️ Xóa</button>
                </div>
            </div>
        </div>
    `).join('');
}

// Lưu giỏ hàng vào localStorage (theo MaSP, SoLuong)
function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}
function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Thêm sản phẩm vào giỏ hàng (theo số lượng)
function addToCart(productId, qty = 1) {
    let cart = getCart();
    qty = Number(qty) || 1; // Đảm bảo qty là số
    // Tìm sản phẩm trong danh sách products
    let product = products.find(p => p.id === productId);
    if (!product) return;

    let found = cart.find(item => item.MaSP === productId);
    if (found) {
        found.SoLuong = Number(found.SoLuong) + qty; // Đảm bảo phép cộng đúng kiểu số
    } else {
        cart.push({
            MaSP: product.id,
            TenSP: product.name,
            Gia: product.price,
            HinhAnh: product.image,
            SoLuong: qty
        });
    }
    saveCart(cart);
    updateCartCount();
    showNotification('Đã thêm vào giỏ hàng!');
}

// Hiển thị giỏ hàng và tính tổng tiền
function renderCart() {
    let cart = getCart();
    const cartItems = document.getElementById('cartItems');
    const totalPrice = document.getElementById('totalPrice');
    
    if (!cart.length) {
        cartItems.innerHTML = '<div style="text-align: center; padding: 50px; color: #666;">Giỏ hàng trống</div>';
        totalPrice.textContent = '0đ';
        return;
    }

    let total = 0;
    cartItems.innerHTML = '';
    cart.forEach(item => {
        const productTotal = item.Gia * item.SoLuong;
        total += productTotal;

        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';
        itemDiv.innerHTML = `
            <div class="cart-item-info">
                <img src="${item.HinhAnh}" alt="${item.TenSP}" class="cart-item-image">
                <div class="cart-item-details">
                    <h4>${item.TenSP}</h4>
                    <p>Giá: ${item.Gia.toLocaleString()}₫</p>
                    <div class="quantity-control">
                        <button onclick="updateQuantity(${item.MaSP}, -1)">➖</button>
                        <span>${item.SoLuong}</span>
                        <button onclick="updateQuantity(${item.MaSP}, 1)">➕</button>
                    </div>
                </div>
            </div>
            <div class="cart-item-actions">
                <p>Tạm tính: ${productTotal.toLocaleString()}₫</p>
                <button class="btn-delete" onclick="removeFromCart(${item.MaSP})">🗑️ Xóa</button>
            </div>
        `;
        cartItems.appendChild(itemDiv);
    });

    totalPrice.textContent = total.toLocaleString() + 'đ';
}

// Cập nhật số lượng trong giỏ hàng
function updateQuantity(MaSP, change) {
    let cart = getCart();
    let item = cart.find(i => i.MaSP === MaSP);
    if (!item) return;
    // Đảm bảo change là số nguyên (có thể là -1 hoặc 1)
    change = Number(change);
    item.SoLuong = Number(item.SoLuong) + change;
    if (item.SoLuong <= 0) {
        removeFromCart(MaSP);
    } else {
        saveCart(cart);
        renderCart();
    }
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(MaSP) {
    let cart = getCart();
    cart = cart.filter(item => item.MaSP !== MaSP);
    saveCart(cart);
    updateCartCount();
    renderCart();
    showNotification('Đã xóa khỏi giỏ hàng!');
}

// Đếm số sản phẩm trong giỏ hàng
function updateCartCount() {
    const cart = getCart();
    const totalCount = cart.reduce((sum, item) => sum + item.SoLuong, 0);
    document.getElementById('cartCount').textContent = totalCount;
}

// Định dạng giá tiền
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '₫';
}

// Lấy tên danh mục
function getCategoryName(category) {
    const categories = {
        food: 'Thực phẩm',
        drink: 'Đồ uống',
        snack: 'Đồ ăn vặt',
        household: 'Gia dụng'
    };
    return categories[category] || category;
}

// Hiển thị thông báo
function showNotification(message) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.style.display = 'block';
    setTimeout(() => { notification.style.display = 'none'; }, 3000);
}

// Countdown timer
function startCountdown() {
    let hours = 1, minutes = 0, seconds = 0;
    function update() {
        if (seconds === 0) {
            if (minutes === 0) {
                if (hours === 0) return;
                hours--; minutes = 59; seconds = 59;
            } else { minutes--; seconds = 59; }
        } else { seconds--; }
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        setTimeout(update, 1000);
    }
    update();
}

// Khi mở panel giỏ hàng, lấy dữ liệu từ server (nếu đã đăng nhập)
function renderCartServer() {
    fetch('/websitebanhangtaphoa/giohang_c/layGioHang')
        .then(res => res.json())
        .then(cart => {
            const cartItems = document.getElementById('cartItems');
            const totalPrice = document.getElementById('totalPrice');
            let totalQty = 0;
            if (!cart || cart.length === 0) {
                cartItems.innerHTML = '<div style="text-align: center; padding: 50px; color: #666;">Giỏ hàng trống</div>';
                totalPrice.textContent = '0đ';
                document.getElementById('cartCount').textContent = '0';
                return;
            }
            let total = 0;
            cartItems.innerHTML = '';
            cart.forEach(item => {
                const productTotal = item.Gia * item.SoLuong;
                total += productTotal;
                totalQty += parseInt(item.SoLuong);
                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item';
                itemDiv.innerHTML = `
                    <div class="cart-item-info">
                        <img src="${item.HinhAnh}" alt="${item.TenSP}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h4>${item.TenSP}</h4>
                            <p>Giá: ${Number(item.Gia).toLocaleString()}₫</p>
                            <div class="quantity-control">
                                <button onclick="updateQuantityServer(${item.MaSP}, -1)">➖</button>
                                <span>${item.SoLuong}</span>
                                <button onclick="updateQuantityServer(${item.MaSP}, 1)">➕</button>
                            </div>
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <p>Tạm tính: ${productTotal.toLocaleString()}₫</p>
                        <button class="btn-delete" onclick="removeFromCartServer(${item.MaSP})">🗑️ Xóa</button>
                    </div>
                `;
                cartItems.appendChild(itemDiv);
            });
            totalPrice.textContent = total.toLocaleString() + 'đ';
            document.getElementById('cartCount').textContent = totalQty;
        });
}
function toggleCart() {
    const panel = document.getElementById('cartPanel');
    panel.style.display = (panel.style.display === 'block') ? 'none' : 'block';
    if (panel.style.display === 'block') renderCartServer();
}
function removeFromCartServer(MaSP) {
    fetch('/websitebanhangtaphoa/giohang_c/xoaSanPham', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'MaSP=' + MaSP
    }).then(() => renderCartServer());
}
function updateQuantityServer(MaSP, change) {
    fetch('/websitebanhangtaphoa/giohang_c/themVaoGio', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'MaSP=' + MaSP + '&SoLuong=' + change
    }).then(() => renderCartServer());
}
function themVaoGioServer(MaSP, SoLuong) {
    fetch('/websitebanhangtaphoa/giohang_c/themVaoGio', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'MaSP=' + MaSP + '&SoLuong=' + SoLuong
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.message) showNotification(data.message);
        renderCartServer();
    });
}

init();