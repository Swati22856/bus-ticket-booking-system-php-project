<?php

include 'db.php';
include 'admin_header.php';



// ✅ Delete User
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE user_id = $id");
    $_SESSION['success'] = "User deleted successfully!";
    header("Location: manage_users.php");
    exit();
}


// ✅ Fetch Users
$users = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
?>

<div class="container mt-5">
  <h2 class="mb-4 fw-bold text-white">Manage Users</h2>

  <!-- ✅ Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>



  <!-- ✅ Users Table -->
  <div class="card shadow border-0 rounded-4">
    <div class="card-body">
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Birth Date</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($u = $users->fetch_assoc()): ?>
          <tr>
            <td><?= $u['user_id'] ?></td>
            <td><?= $u['full_name'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['phone'] ?></td>
            <td><?= $u['birth_dt'] ?></td>
            <td><?= ucfirst($u['gender']) ?></td>
            <td><span class="badge bg-info"><?= ucfirst($u['role']) ?></span></td>
            <td><?= $u['created_at'] ?></td>
            <td>
             
              <!-- Delete -->
              <a href="manage_users.php?delete=<?= $u['user_id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Delete this user?');">
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

<!-- ✅ Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Birth Date</label>
            <input type="date" name="birth_dt" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="add_user" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
