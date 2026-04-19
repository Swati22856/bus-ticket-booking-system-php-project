<?php

include 'db.php';
include 'admin_header.php';

// ✅ Handle Delete Message
if (isset($_GET['delete'])) {
    $msg_id = intval($_GET['delete']);
    $conn->query("DELETE FROM contacts WHERE id = $msg_id");
    $_SESSION['success'] = "Message deleted successfully!";
    header("Location: manage_contacts.php");
    exit();
}

// ✅ Fetch Messages
$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-white">Manage Contact Messages</h2>

  <!-- ✅ Success / Error Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- ✅ Messages Table -->
  <div class="card shadow border-0 rounded-4">
    <div class="card-body">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($msg = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $msg['id'] ?></td>
            <td><?= htmlspecialchars($msg['name']) ?></td>
            <td><?= htmlspecialchars($msg['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
            <td><?= date("d M Y, H:i", strtotime($msg['created_at'])) ?></td>
            <td>
              <!-- Delete -->
              <a href="manage_contacts.php?delete=<?= $msg['id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this message?');">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
