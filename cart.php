<?php
session_start();
include 'db.php';
include 'header.php';
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'cart';


// Update quantity via AJAX
if (isset($_POST['update_cart'])) {
    $pid = $_POST['pid'];
    $qty = max(1, intval($_POST['qty']));
    $_SESSION['cart'][$pid] = $qty;
    echo "success";
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}

// Get cart products
$cart = $_SESSION['cart'] ?? [];
$product_ids = array_keys($cart);
$products = [];
$total = 0;

if (!empty($product_ids)) {
    $ids = implode(",", $product_ids);
    $query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>🛒 Your Cart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f0f2f5;
    font-family: 'Segoe UI', Arial, sans-serif;
}

/* Header */
.header {
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    color: white;
    padding: 30px 20px;
    text-align: center;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.header h2 {
    font-size: 2rem;
}
.header a {
    color: white;
    font-weight: bold;
    text-decoration: none;
}

/* Table styling */
.table-container {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.table th, .table td {
    vertical-align: middle !important;
}
.qty-input {
    width: 80px;
}

/* Buttons */
.btn-gradient {
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    border: none;
    color: white;
    transition: 0.3s;
}
.btn-gradient:hover {
    background: linear-gradient(90deg, #feb47b, #ff7e5f);
}

/* Image zoom */
.zoom-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    transition: transform 0.3s ease;
    cursor: zoom-in;
}
.zoom-image:hover {
    transform: scale(1.2);
}

/* Fullscreen modal */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
}
.image-modal img {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 85%;
    border-radius: 12px;
}
.close-btn {
    position: absolute;
    top: 20px;
    right: 45px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
.close-btn:hover {
    color: #ccc;
}
</style>
</head>
<body>

<div class="container mt-4">
    <div class="header d-flex justify-content-between align-items-center">
        <h2>🛒 Your Cart</h2>
        <a href="products.php">⬅️ Continue Shopping</a>
    </div>

    <?php if(empty($products)): ?>
        <div class="alert alert-info text-center">Your cart is empty. 😢</div>
    <?php else: ?>
    <div class="table-container">
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($products as $p): 
                $qty = $cart[$p['id']];
                $subtotal = $p['price'] * $qty;
                $total += $subtotal;
            ?>
                <tr>
                    <td>
                        <img src="product_images/<?php echo $p['image']; ?>" class="zoom-image" alt="">
                    </td>
                    <td> <?php echo $p['name']; ?> </td>
                    <td>₹<?php echo number_format($p['price'],2); ?></td>
                    <td>
                        <input type="number" min="1" value="<?php echo $qty; ?>" class="form-control qty-input" data-id="<?php echo $p['id']; ?>">
                    </td>
                    <td class="subtotal">₹<?php echo number_format($subtotal,2); ?></td>
                    <td><a href="?remove=<?php echo $p['id']; ?>" class="btn btn-sm btn-gradient">🗑 Remove</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h4>💰 Grand Total: ₹<span id="grand-total"><?php echo number_format($total,2); ?></span></h4>
            <button class="btn btn-gradient btn-lg mt-2">✅ Buy Now</button>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Fullscreen modal -->
<div id="imageModal" class="image-modal">
    <span class="close-btn">&times;</span>
    <img class="modal-content" id="fullImage">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Update quantity live via AJAX
$(".qty-input").on("input", function() {
    let pid = $(this).data("id");
    let qty = $(this).val();
    if(qty < 1) qty = 1;
    $.post("cart.php", {update_cart:1, pid:pid, qty:qty}, function(){
        location.reload();
    });
});

// Fullscreen image modal
document.querySelectorAll(".zoom-image").forEach(img => {
    img.addEventListener("click", function() {
        const modal = document.getElementById("imageModal");
        const fullImage = document.getElementById("fullImage");
        modal.style.display = "block";
        fullImage.src = this.src;
    });
});
document.querySelector(".close-btn").addEventListener("click", () => {
    document.getElementById("imageModal").style.display = "none";
});
window.addEventListener("click", (e) => {
    const modal = document.getElementById("imageModal");
    if (e.target === modal) modal.style.display = "none";
});
window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        document.getElementById("imageModal").style.display = "none";
    }
});
</script>

</body>
</html>
