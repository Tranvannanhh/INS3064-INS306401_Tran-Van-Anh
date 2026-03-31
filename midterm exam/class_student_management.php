<?php
// ================== DATABASE CONNECTION (PDO) ==================
$host = "localhost";
$dbname = "class_student_management_db";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ================== HANDLE CREATE ==================
if(isset($_POST['add'])){
    $check = $conn->prepare("SELECT id FROM students WHERE student_code=?");
    $check->execute([$_POST['student_code']]);

    if($check->rowCount() > 0){
        $message = "❌ Student code already exists!";
    } else {
        $sql = "INSERT INTO students (class_id, student_code, full_name, date_of_birth, email, gender)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['class_id'],
            $_POST['student_code'],
            $_POST['full_name'],
            $_POST['date_of_birth'],
            $_POST['email'],
            $_POST['gender']
        ]);

        header("Location: ".$_SERVER['PHP_SELF']."?msg=added");
        exit();
    }
}

// ================== HANDLE DELETE ==================
if(isset($_GET['delete'])){
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$_GET['delete']]);

    header("Location: ".$_SERVER['PHP_SELF']."?msg=deleted");
    exit();
}

// ================== HANDLE GET EDIT DATA ==================
$editData = null;
if(isset($_GET['edit'])){
    $stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch();
}

// ================== HANDLE UPDATE ==================
if(isset($_POST['update'])){
    $check = $conn->prepare("SELECT id FROM students WHERE student_code=? AND id!=?");
    $check->execute([$_POST['student_code'], $_POST['id']]);

    if($check->rowCount() > 0){
        $message = "❌ Student code already exists!";
    } else {
        $sql = "UPDATE students SET 
                class_id=?, student_code=?, full_name=?, date_of_birth=?, email=?, gender=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $_POST['class_id'],
            $_POST['student_code'],
            $_POST['full_name'],
            $_POST['date_of_birth'],
            $_POST['email'],
            $_POST['gender'],
            $_POST['id']
        ]);

        header("Location: ".$_SERVER['PHP_SELF']."?msg=updated");
        exit();
    }
}

// ================== SEARCH + FILTER ==================
$keyword = $_GET['keyword'] ?? '';
$class_filter = $_GET['class_id'] ?? '';

$sql = "SELECT students.*, classes.class_name 
        FROM students 
        JOIN classes ON students.class_id = classes.id
        WHERE 1";

$params = [];

if($keyword){
    $sql .= " AND (student_code LIKE ? OR full_name LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

if($class_filter != ''){
    $sql .= " AND students.class_id = ?";
    $params[] = $class_filter;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$students = $stmt->fetchAll();

// ================== LOAD CLASSES ==================
$classStmt = $conn->prepare("SELECT * FROM classes");
$classStmt->execute();
$classes = $classStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --bg-body: #f8fafc;
            --text-main: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        /* Message Styles */
        .msg {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Form Search & Filter */
        .search-container {
            display: flex;
            gap: 15px;
            background: #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Input & Select styling */
        input, select {
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            transition: all 0.2s;
            font-size: 14px;
        }

        input:focus, select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Buttons */
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s, opacity 0.2s;
            background: var(--primary-color);
            color: white;
        }

        button:hover { opacity: 0.9; }
        button:active { transform: scale(0.98); }

        /* Add/Edit Section */
        .form-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        .form-title {
            width: 100%;
            grid-column: 1 / -1;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .input-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        /* Table Design */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 12px;
            overflow: hidden; /* Bo góc table */
        }

        th {
            background: #f1f5f9;
            color: var(--secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        tr:hover { background-color: #f8fafc; }

        /* Action Links */
        .btn-edit { color: var(--primary-color); font-weight: 600; }
        .btn-delete { color: var(--danger-color); font-weight: 600; margin-left: 10px; }

        .gender-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #e2e8f0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🎓 Student Management System</h2>

    <?php if(isset($_GET['msg'])): ?>
        <div class="msg">
            <?php 
                if($_GET['msg']=='added') echo "✅ Added successfully!";
                if($_GET['msg']=='updated') echo "✅ Updated successfully!";
                if($_GET['msg']=='deleted') echo "🗑 Deleted successfully!";
            ?>
        </div>
    <?php endif; ?>

    <?php if(isset($message)): ?>
        <div class="msg" style="background:#fee2e2; color:#991b1b; border-color:#fecaca;"><?= $message ?></div>
    <?php endif; ?>

    <form method="GET" class="search-container">
        <div class="input-group" style="flex: 1; min-width: 200px;">
            <label>🔍 Search</label>
            <input type="text" name="keyword" placeholder="Name or Code..." value="<?= $keyword ?>">
        </div>
        
        <div class="input-group">
            <label>🎯 Class</label>
            <select name="class_id">
                <option value="">All Classes</option>
                <?php foreach($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($class_filter == $c['id'])?'selected':'' ?>>
                        <?= $c['class_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" style="align-self: flex-end; margin-bottom: 5px;">Filter Results</button>
    </form>

    <form method="POST">
        <div class="form-section">
            <div class="form-title">
                <?= $editData ? "✏️ Edit Student Information" : "➕ Register New Student" ?>
            </div>
            
            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <div class="input-group">
                <label>Student Code</label>
                <input name="student_code" value="<?= $editData['student_code'] ?? '' ?>" required placeholder="e.g. 123">
            </div>

            <div class="input-group">
                <label>Full Name</label>
                <input name="full_name" value="<?= $editData['full_name'] ?? '' ?>" required placeholder="e.g. Van Anh">
            </div>

            <div class="input-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?= $editData['date_of_birth'] ?? '' ?>">
            </div>

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?= $editData['email'] ?? '' ?>" placeholder="example@vnu.com">
            </div>

            <div class="input-group">
                <label>Class</label>
                <select name="class_id">
                    <?php foreach($classes as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (isset($editData) && $editData['class_id']==$c['id'])?'selected':'' ?>>
                            <?= $c['class_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="Male" <?= ($editData['gender'] ?? '')=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?= ($editData['gender'] ?? '')=='Female'?'selected':'' ?>>Female</option>
                    <option value="Other" <?= ($editData['gender'] ?? '')=='Other'?'selected':'' ?>>Other</option>
                </select>
            </div>

            <div class="input-group" style="grid-column: 1 / -1; align-items: flex-end;">
                <?php if($editData): ?>
                    <button name="update" style="background: var(--success-color); width: 150px;">Update Student</button>
                <?php else: ?>
                    <button name="add" style="width: 150px;">Add Student</button>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $row): ?>
                <tr>
                    <td><span style="color: #94a3b8;">#<?= $row['id'] ?></span></td>
                    <td style="font-weight: 600;"><?= $row['student_code'] ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['date_of_birth'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><span class="gender-badge"><?= $row['gender'] ?></span></td>
                    <td><b style="color: var(--secondary-color)"><?= $row['class_name'] ?></b></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($students)): ?>
                <tr>
                    <td colspan="8" style="padding: 40px; color: #94a3b8;">No students found matching your search.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>