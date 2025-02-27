<?php
require_once('connect_db.php');
session_start();

// ตัวอย่างข้อมูลพนักงาน รวมถึงแอดมิน
$valid_employees = [
    'E001' => 'password123', // employee_id => password
    'E002' => 'password456',
    'E003' => 'password789',
];

// เพิ่มแอดมิน
$admin_id = 'admin';
$admin_password = 'sakdithat';

// ตรวจสอบการล็อกอิน
if (isset($_POST['employee_id']) && isset($_POST['passwords'])) {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['passwords'];

    // ตรวจสอบว่าเป็นแอดมิน
    if ($employee_id === $admin_id && $password === $admin_password) {
        $_SESSION['employee_id'] = $employee_id;
        $_SESSION['employee_name'] = 'Sakdithat Chamang';
        $_SESSION['is_admin'] = true; // กำหนดว่าเป็นแอดมิน
        header('Location: navbar.php'); // รีไดเร็กต์ไปหน้าแอดมิน
        exit();
    } 
    // ตรวจสอบว่าเป็นพนักงาน
    elseif (isset($valid_employees[$employee_id]) && $valid_employees[$employee_id] === $password) {
        $_SESSION['employee_id'] = $employee_id;
        $_SESSION['employee_name'] = $employee_id;  // หรือสามารถใช้ชื่อพนักงานที่เก็บไว้
        $_SESSION['is_admin'] = false; // กำหนดว่าเป็นพนักงาน
        header('Location: navbar.php'); // รีไดเร็กต์ไปหน้าพนักงาน
        exit();
    } else {
        echo "<script>alert('รหัสพนักงานหรือรหัสผ่านไม่ถูกต้อง');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project_IT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <style>
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dropdown-menu {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .container {
            margin-top: 80px;
        }
        .footer {
            background-color: #222;
            color: white;
            padding: 20px 0;
        }
        .footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer .text-muted {
            margin: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Project_IT</a>
        
        <?php if (isset($_SESSION['employee_name'])): ?>
            <span class="navbar-text ml-auto">
                สวัสดี, <?php echo htmlspecialchars($_SESSION['employee_name']); ?>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <strong>(แอดมิน)</strong> <!-- แสดงข้อความว่าเป็นแอดมิน -->
                <?php endif; ?>
            </span>
        <?php endif; ?>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="navbar.php?p=home">หน้าแรก <span class="sr-only">(current)</span></a>
                </li>
                <?php if (isset($_SESSION['employee_name'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            โครงการ
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="navbar.php?p=project">เเสดงข้อมูลโครงการ</a>
                            <a class="dropdown-item" href="navbar.php?p=project1">ตารางตำแหน่ง</a>
                            <a class="dropdown-item" href="navbar.php?p=project2">ตารางพนักงาน</a>
                            <a class="dropdown-item" href="navbar.php?p=project3">ค้นหา-พนักงาน</a>
                            <a class="dropdown-item" href="navbar.php?p=project4">พนักงาน-เเบ่งหน้า</a>
                            <a class="dropdown-item" href="navbar.php?p=project5">การแสดงข้อมูล Group By</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            รายได้-สรุปชั่วโมงงทำงาน
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="navbar.php?p=p1">สรุปชั่วโมงการทำงาน</a>
                            <a class="dropdown-item" href="navbar.php?p=project6">รายได้พนักงาน</a>
                        </div>
                    <li class="nav-item">
                        <a class="nav-link" href="?p=p2">employees กับ position</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">ออกจากระบบ</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                // ตรวจสอบว่าเข้าสู่ระบบแล้วหรือไม่
                if (isset($_SESSION['employee_name'])) {
                    if (isset($_GET['p'])) {
                        
                        switch ($_GET['p']) {
                            // หน้าแรก
                            case 'project':
                                require_once('select_project2.php');
                                echo "<h2>ข้อมูลโครงการ</h2>";
                                break;
                            // ตำแหน่ง
                            case 'project1':
                                require_once('positions.php');
                                echo "<h2>ตารางตำแหน่ง</h2>";
                                break;
                            // พนักงาน
                            case 'project2':
                                require_once('employees.php');
                                echo "<h2>ตารางพนักงาน</h2>";
                                break;
                            // ค้นหา-พนักงาน
                            case 'p1':
                                require_once('project_hours.php');
                                echo "<h2>สรุปชั่วโมงการทำงาน</h2>";
                                break;
                                echo "<h2>ตารางพนักงาน</h2>";
                                break;
                            // ค้นหา-พนักงาน
                            case 'p1':
                                require_once('project_hours.php');
                                echo "<h2>สรุปชั่วโมงการทำงาน</h2>";
                                break;
                            // พนักงาน-เเบ่งหน้า
                            case 'p2':
                                require_once('select_emp_position.php');
                                break;
                            // ค้นหา-พนักงาน
                            case 'project3':
                             require_once('select_emp_position_search.php');
                                  break;
                            // พนักงาน-เเบ่งหน้า
                            case 'project4':
                                 require_once('select_emp_position_page.php');
                               break;
                               case 'select_groupby_where': 
                                 require_once('select_groupby_where.php');
                                    break;

                            case 'project5':
                             require_once('select_groupBy.php');
                             break;


                             case 'project6';
                                require_once('project_list.php');
                                break;
                                


                                

                            

                            // หน้าแรก
                            default:
                                echo "<h2>ยินดีต้อนรับ!</h2>";
                                break;
                        }       
                    } else {
                        // หน้าแรก
                        echo "<h2>ยินดีต้อนรับ!</h2>";
                    }
                } else {
                    // หน้าเข้าสู่ระบบ
                    require_once('project_hours.php');
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
