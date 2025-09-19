<?php
require_once 'classes/Post.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  header('Location: index.php?error=Client ID not provided');
  exit();
}

$post = new Post();
$client = $post->getById($id);

if (!$client) {
  header('Location: index.php?error=Client not found');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Client</title>
  <link href="/css/create.css" rel="stylesheet" />
</head>

<body>
  <?php if (isset($_GET['error'])): ?>
    <div class="error-message">
      Error: <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
  <?php endif; ?>

  <div class="container">
    <div class="header-actions">
      <h2>Edit Client</h2>
      <a href="index.php" class="back-button">Back to List</a>
    </div>

    <div class="form-container">
      <h3 class="form-title">Client Information</h3>

      <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">

        <div class="form-row">
          <div class="form-group">
            <label for="name">First Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>
          </div>

          <div class="form-group">
            <label for="lastname">Last Name *</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($client['lastname']); ?>" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required>
          </div>

          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
          </div>
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address"><?php echo htmlspecialchars($client['address'] ?? ''); ?></textarea>
        </div>

        <div class="button-group">
          <a href="index.php" class="cancel-button">Cancel</a>
          <button type="submit" class="submit-button">Update Client</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
