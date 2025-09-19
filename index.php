<?php
require_once __DIR__ . '/classes/Post.php';

$posts = new Post();

$records_per_page = 7;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

$total_records = $posts->getTotalCount();

$total_pages = ceil($total_records / $records_per_page);
if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;

$offset = ($current_page - 1) * $records_per_page;

$users = $posts->getPaginated($offset, $records_per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crud</title>
  <link href="css/styles.css" rel="stylesheet" />
  <style>

  </style>
</head>

<body>
  <div class="container">
    <header>
      <h1>User Management System</h1>
    </header>

    <div class="header-actions">
      <h2>Clients List</h2>
      <a href="create.php" class="create-button">Create New Record</a>
    </div>

    <?php
    if (isset($_GET['success'])): ?>
      <div class="success-message">
        <?php echo htmlspecialchars($_GET['success']); ?>
      </div>
    <?php endif; ?>


    <?php if (isset($_GET['success'])): ?>
      <div class="success-message">
        Client updated successfully!
      </div>
    <?php endif; ?>


    <?php if (isset($_GET['error'])): ?>
      <div class="error-message">
        Error: <?php echo htmlspecialchars($_GET['error']); ?>
      </div>
    <?php endif; ?>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Lastname</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
                <td class="controls">
                  <a class="edit-link" href="edit.php?id=<?php echo $user['id']; ?>">Edit</a>
                  <a class="delete-link" href="delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align: center;">No records found</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <?php if ($total_pages > 1): ?>
        <ul class="pagination">
          <li>
            <?php if ($current_page > 1): ?>
              <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
            <?php else: ?>
              <span class="disabled">&laquo; Previous</span>
            <?php endif; ?>
          </li>

          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li>
              <?php if ($i == $current_page): ?>
                <span class="active"><?php echo $i; ?></span>
              <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              <?php endif; ?>
            </li>
          <?php endfor; ?>

          <li>
            <?php if ($current_page < $total_pages): ?>
              <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
            <?php else: ?>
              <span class="disabled">Next &raquo;</span>
            <?php endif; ?>
          </li>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>
