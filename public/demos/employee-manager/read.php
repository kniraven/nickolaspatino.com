<?php
$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
require_once $projectRoot . '/config/employeemanager_db.php';
require_once __DIR__ . '/includes/header.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT e.*, m.first_name AS manager_first_name, m.last_name AS manager_last_name 
                       FROM employees e 
                       LEFT JOIN employees m ON e.manager = m.id 
                       WHERE e.id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Employee Details</h2>
    <?php if ($employee) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white shadow-md rounded-lg p-4">
            <p class="text-sm text-gray-600"><strong>ID:</strong> <?php echo htmlspecialchars($employee['id']); ?></p>
            <p class="text-sm text-gray-600"><strong>First Name:</strong> <?php echo htmlspecialchars($employee['first_name']); ?></p>
            <p class="text-sm text-gray-600"><strong>Last Name:</strong> <?php echo htmlspecialchars($employee['last_name']); ?></p>
            <p class="text-sm text-gray-600"><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
            <p class="text-sm text-gray-600"><strong>Position:</strong> <?php echo htmlspecialchars($employee['position']); ?></p>
            <p class="text-sm text-gray-600"><strong>Team:</strong> <?php echo htmlspecialchars($employee['team']); ?></p>
            <p class="text-sm text-gray-600"><strong>Manager:</strong> <?php echo $employee['manager'] ? htmlspecialchars($employee['manager_first_name'] . ' ' . $employee['manager_last_name']) : 'None'; ?></p>
            <p class="text-sm text-gray-600"><strong>Hire Date:</strong> <?php echo htmlspecialchars($employee['hire_date']); ?></p>
            <p class="text-sm text-gray-600"><strong>Termination Date:</strong> <?php echo htmlspecialchars($employee['termination_date']); ?></p>
        </div>
    <?php else : ?>
        <p>Employee not found.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
