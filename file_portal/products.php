<?php
session_start();
include 'db.php';
include 'header.php';




// Dynamic page variable
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'products';


// Create cart session if not exists
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['product_id'];
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid] += 1;
    } else {
        $_SESSION['cart'][$pid] = 1;
    }
    header("Location: cart.php");
    exit();
}

// Fetch products
$products = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>🛍 Amazing Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: #f0f2f5;
  font-family: 'Segoe UI', Arial, sans-serif;
}
.header {
  background: linear-gradient(90deg, #ff7e5f, #feb47b);
  color: white;
  padding: 30px 20px;
  text-align: center;
  border-radius: 12px;
  margin-bottom: 30px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.header h1 {
  font-size: 2.5rem;
  margin-bottom: 5px;
}
.header p {
  font-size: 1.1rem;
}
.card {
  border: none;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}
.image-container {
  overflow: hidden;
}
.zoom-image {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.3s ease;
  cursor: zoom-in;
}
.zoom-image:hover {
  transform: scale(1.2);
}
.card-body {
  text-align: center;
}
.card-body h5 {
  font-size: 1.2rem;
  margin: 10px 0 5px;
}
.card-body p {
  font-size: 1rem;
  color: #ff4b5c;
  font-weight: bold;
}
.btn-add {
  background: linear-gradient(90deg, #ff7e5f, #feb47b);
  color: white;
  border: none;
  width: 100%;
  transition: background 0.3s ease;
}
.btn-add:hover {
  background: linear-gradient(90deg, #feb47b, #ff7e5f);
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
  <div class="header">
    <h1>🛍 Shop the Best Products!</h1>
    <p> Grab your favorites and enjoy amazing deals </p>
    <a href="cart.php" class="btn btn-light btn-lg mt-2">🛒 View Cart (<?php echo count($_SESSION['cart']); ?>)</a>
  </div>

  <div class="row">
    <?php while($p = mysqli_fetch_assoc($products)): ?>
    <div class="col-md-3 mb-4">
      <div class="card">
        <div class="image-container">
          <img src="product_images/<?php echo $p['image']; ?>"
               alt="<?php echo htmlspecialchars($p['name']); ?>"
               class="zoom-image">
        </div>
        <div class="card-body">
          <h5> <?php echo $p['name']; ?> </h5>
          <p>₹<?php echo number_format($p['price'],2); ?></p>
          <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            <button type="submit" name="add_to_cart" class="btn btn-add mt-2">➕ Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Fullscreen modal -->
<div id="imageModal" class="image-modal">
  <span class="close-btn">&times;</span>
  <img class="modal-content" id="fullImage">
</div>

<script>
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
