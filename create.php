<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Client</title>
  <link href="/css/create.css" rel="stylesheet" />
</head>

<body>
  <div class="container">
    <div class="header-actions">
      <h2>Add New Client</h2>
      <a href="index.php" class="back-button">Back to List</a>
    </div>

    <div class="form-container">
      <h3 class="form-title">Client Information</h3>

      <form action="save.php" method="POST">
        <div class="form-row">
          <div class="form-group">
            <label for="name">First Name *</label>
            <input type="text" id="name" name="name" required>
          </div>

          <div class="form-group">
            <label for="lastname">Last Name *</label>
            <input type="text" id="lastname" name="lastname" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required>
          </div>

          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required>
          </div>
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address"></textarea>
        </div>

        <div class="button-group">
          <a href="index.php" class="cancel-button">Cancel</a>
          <button type="submit" class="submit-button">Save Client</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>