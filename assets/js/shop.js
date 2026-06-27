let currentCategory = '';

function openCategory(cat){
    currentCategory = cat;

    document.getElementById('categoryView').style.display = 'none';
    document.getElementById('productView').style.display = 'block';

    document.getElementById('crochetFilters').style.display = (cat === 'crochet') ? 'flex' : 'none';
    document.getElementById('embroideryFilters').style.display = (cat === 'embroidery') ? 'flex' : 'none';

    filterProducts(cat, 'all');
}

function goBack(){
    document.getElementById('productView').style.display = 'none';
    document.getElementById('categoryView').style.display = 'block';
}

function filterProducts(cat, sub){
    const cards = document.querySelectorAll('.product-card');

    cards.forEach(card => {
        const cardCat = card.getAttribute('data-cat');
        const cardSub = card.getAttribute('data-sub');

        if(cardCat === cat && (sub === 'all' || cardSub === sub)){
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Filter button click handling
document.addEventListener('click', function(e){
    if(e.target.classList.contains('filter-btn')){
        const cat = e.target.getAttribute('data-cat');
        const sub = e.target.getAttribute('data-sub');

        // Remove active class from siblings only
        const siblings = e.target.parentElement.querySelectorAll('.filter-btn');
        siblings.forEach(btn => btn.classList.remove('active'));
        e.target.classList.add('active');

        filterProducts(cat, sub);
    }
});

function toggleWishlist(btn){
    const id = btn.getAttribute('data-id');

    fetch('toggle-wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'added'){
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');

            if(window.location.pathname.includes('wishlist.php')){
                btn.closest('.product-card').remove();
            }
        }

        const navCount = document.querySelector('.wishlist-count');
        if(navCount){
            navCount.textContent = data.count;
        }
    });
}

function addToCart(btn){
    const id = btn.getAttribute('data-id');
    const originalText = btn.textContent;

    fetch('add-to-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        btn.textContent = 'Added ✓';
        setTimeout(() => { btn.textContent = originalText; }, 1200);

        const cartCount = document.querySelector('.cart-count');
        if(cartCount){
            cartCount.textContent = data.count;
        }
    });
}

function updateQty(id, change){
    const action = change > 0 ? 'increase' : 'decrease';

    fetch('update-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id + '&action=' + action
    })
    .then(res => res.json())
    .then(data => {
        if(data.qty <= 0){
            document.getElementById('qty-' + id).closest('.cart-row').remove();
        } else {
            document.getElementById('qty-' + id).textContent = data.qty;
            document.getElementById('subtotal-' + id).textContent = '₹' + data.subtotal;
        }

        document.getElementById('grandTotal').textContent = '₹' + data.grandTotal;

        const cartCount = document.querySelector('.cart-count');
        if(cartCount){
            cartCount.textContent = data.cartCount;
        }
    });
}

function removeFromCart(id){
    fetch('remove-from-cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        document.querySelector('.cart-row button[onclick*="' + id + '"]').closest('.cart-row').remove();

        const cartCount = document.querySelector('.cart-count');
        if(cartCount){
            cartCount.textContent = data.count;
        }

        location.reload(); // simplest way to refresh grand total after removal
    });
}