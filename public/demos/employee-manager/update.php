<?php
$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
require_once $projectRoot . '/config/employeemanager_db.php';
require_once __DIR__ . '/includes/header.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all employees for the manager dropdown
$managers = $pdo->query("SELECT id, first_name, last_name FROM employees")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $position = htmlspecialchars($_POST['position']);
    $team = htmlspecialchars($_POST['team']);
    $manager = !empty($_POST['manager']) ? htmlspecialchars($_POST['manager']) : null;
    $hire_date = !empty($_POST['hire_date']) ? htmlspecialchars($_POST['hire_date']) : null;
    $termination_date = !empty($_POST['termination_date']) ? htmlspecialchars($_POST['termination_date']) : null;

    $stmt = $pdo->prepare("UPDATE employees SET first_name = ?, last_name = ?, email = ?, position = ?, team = ?, manager = ?, hire_date = ?, termination_date = ? WHERE id = ?");
    $stmt->execute([$first_name, $last_name, $email, $position, $team, $manager, $hire_date, $termination_date, $id]);

    header('Location: index.php');
    exit();
}
?>

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Edit Employee</h2>
    <?php if ($employee) : ?>
        <form method="post" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($employee['first_name']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($employee['last_name']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Position:</label>
                    <input type="text" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="team" class="block text-sm font-medium text-gray-700">Team:</label>
                    <input type="text" name="team" value="<?php echo htmlspecialchars($employee['team']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="manager" class="block text-sm font-medium text-gray-700">Manager:</label>
                    <select name="manager" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">None</option>
                        <?php foreach ($managers as $manager): ?>
                            <option value="<?php echo $manager['id']; ?>" <?php if ($employee['manager'] == $manager['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($manager['first_name'] . ' ' . $manager['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date:</label>
                    <input type="date" name="hire_date" value="<?php echo htmlspecialchars($employee['hire_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="termination_date" class="block text-sm font-medium text-gray-700">Termination Date:</label>
                    <input type="date" name="termination_date" value="<?php echo htmlspecialchars($employee['termination_date']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="mt-4">
                <input type="submit" value="Update Employee" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            </div>
        </form>
    <?php else : ?>
        <p>Employee not found.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
