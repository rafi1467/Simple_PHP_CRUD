<?php
/**
 * CREATE: Add a new student record
 * Note for Instructor: Validation blocks are intentionally commented out
 * so SQA can discover bugs first, and Developers can uncomment them to fix.
 */
require_once __DIR__ . '/config/db.php';

$errors = [];
$name   = '';
$email  = '';
$phone  = '';
$department   = '';
$cgpa = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $department   = trim($_POST['department'] ?? '');
    $cgpa = trim($_POST['cgpa'] ?? '');

    // =====================================================================
    // [VALIDATION 1] Required / Empty Fields Check (Commented out for SQA)
    // =====================================================================
    
    if (empty($name) || empty($email) || empty($phone) || empty($department) || $cgpa === '') {
        $errors[] = 'All fields are required and cannot be empty.';
    }
    

    // =====================================================================
    // [VALIDATION 2] Name Length Boundary Check: 3 to 50 characters
    // =====================================================================
    
    if (!empty($name) && (strlen($name) < 3 || strlen($name) > 50)) {
        $errors[] = 'Name must be between 3 and 50 characters long.';
    }
    

    // =====================================================================
    // [VALIDATION 3] Email Format Validation
    // =====================================================================
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address (e.g. user@example.com).';
    }
    

    // =====================================================================
    // [VALIDATION 4] Phone Format Validation (Digits only, 11 digits)
    // =====================================================================
    
    if (!empty($phone) && !preg_match('/^[0-9]{11}$/', $phone)) {
        $errors[] = 'Phone number must be exactly 11 digits (numbers only).';
    }
    

    // =====================================================================
    // [VALIDATION 5] CGPA Numeric & Boundary Validation (0 to 4)
    // =====================================================================
    
    if ($cgpa !== '' && (!is_numeric($cgpa) || (float) $cgpa < 0 || (float) $cgpa > 4)) {
        $errors[] = 'CGPA must be a number between 0 and 4.';
    }
    

    // If there are no validation errors, insert into the database
    if (empty($errors)) {
        $safeName   = mysqli_real_escape_string($conn, $name);
        $safeEmail  = mysqli_real_escape_string($conn, $email);
        $safePhone  = mysqli_real_escape_string($conn, $phone);
        $safeDepartment   = mysqli_real_escape_string($conn, $department);
        $safeCgpa = (float) $cgpa;

        $sql = "INSERT INTO students (name, email, phone, department, cgpa)
                VALUES ('$safeName', '$safeEmail', '$safePhone', '$safeDepartment', '$safeCgpa')";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php?msg=created');
            exit;
        } else {
            $errors[] = 'Database Error: ' . mysqli_error($conn);
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="page-header">
        <h1>Add New Student</h1>
        <a href="index.php" class="btn btn-secondary">&larr; Back to List</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name *</label>
            <!-- SQA DEMO: HTML 'required', 'minlength', 'maxlength' are omitted -->
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="e.g. Alice Johnson">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required minlength="3" maxlength="50" placeholder="e.g. Alice Johnson"> -->
            <span class="hint">Expected: 3 to 50 characters, required.</span>
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <!-- SQA DEMO: Using type="text" instead of type="email" and no 'required' -->
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="e.g. alice@example.com">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required placeholder="e.g. alice@example.com"> -->
            <span class="hint">Expected: Valid email format (must contain @ and domain).</span>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="e.g. 01711000001">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required pattern="[0-9]{11}" title="11 digit phone number" placeholder="e.g. 01711000001"> -->
            <span class="hint">Expected: Exactly 11 digits (numbers only).</span>
        </div>

        <div class="form-group">
            <label for="department">Department *</label>
            <select id="department" name="department">
                <option value="">-- Select Department --</option>
                <option value="CSE" <?php if ($department === 'CSE') echo 'selected'; ?>>CSE</option>
                <option value="SWE" <?php if ($department === 'SWE') echo 'selected'; ?>>SWE</option>
                <option value="BBA" <?php if ($department === 'BBA') echo 'selected'; ?>>BBA</option>
                <option value="English" <?php if ($department === 'English') echo 'selected'; ?>>English</option>
            </select>
            <span class="hint">Expected: Must select a valid department.</span>
        </div>

        <div class="form-group">
            <label for="cgpa">CGPA *</label>
            <!-- SQA DEMO: No min="0" or max="4.00" attribute -->
            <input type="number" step="0.01" id="cgpa" name="cgpa" value="<?php echo htmlspecialchars($cgpa); ?>" placeholder="e.g. 3.50">
            <!-- FIX: Uncomment below for client-side HTML validation -->
            <!-- <input type="number" step="0.01" min="0" max="4.00" id="cgpa" name="cgpa" value="<?php echo htmlspecialchars($cgpa); ?>" required placeholder="e.g. 3.50"> -->
            <span class="hint">Expected: Positive number between 0 and 4.00</span>
        </div>

        <button type="submit" class="btn btn-primary">Save Student</button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
