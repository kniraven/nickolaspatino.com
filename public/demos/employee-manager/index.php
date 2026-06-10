<?php
$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
require_once $projectRoot . '/config/employeemanager_db.php';
require_once __DIR__ . '/includes/header.php';

// Fetch sort and filter parameters
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Determine the opposite sorting order for toggling
$opposite_order = $sort_order === 'asc' ? 'desc' : 'asc';

// Build SQL query with robust search and sorting
$sql = "SELECT e.id, e.first_name, e.last_name, e.email, e.position, e.team, e.manager, e.hire_date, e.termination_date, 
        m.first_name AS manager_first_name, m.last_name AS manager_last_name 
        FROM employees e 
        LEFT JOIN employees m ON e.manager = m.id";

// Add search condition
if (!empty($search_query)) {
    $sql .= " WHERE 
                e.first_name LIKE :search 
             OR e.last_name LIKE :search 
             OR e.email LIKE :search 
             OR e.position LIKE :search 
             OR e.team LIKE :search 
             OR CONCAT(m.first_name, ' ', m.last_name) LIKE :search
             OR e.hire_date LIKE :search
             OR e.termination_date LIKE :search";
}

// Add sorting condition
$sql .= " ORDER BY $sort_column $sort_order";

// Prepare and execute SQL query
$stmt = $pdo->prepare($sql);

if (!empty($search_query)) {
    $stmt->bindValue(':search', '%' . $search_query . '%', PDO::PARAM_STR);
}

$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Employee List</h2>
    
    <!-- Search Form -->
    <form method="GET" class="mb-4 flex items-center space-x-2">
        <input type="text" name="search" placeholder="Search employees..." value="<?php echo htmlspecialchars($search_query); ?>" class="border border-gray-300 rounded-md px-3 py-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Search</button>
        <a href="index.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Reset</a>

        <!-- Display current filter/search description if a search query exists -->
        <?php if (!empty($search_query)) : ?>
            <span class="text-sm text-gray-500">Filtering results for: "<strong><?php echo htmlspecialchars($search_query); ?></strong>"</span>
        <?php endif; ?>
    </form>

    <!-- Table format for desktop view -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <!-- Add sort links with arrows to the headers -->
                    <?php
                    function sortingArrow($column) {
                        global $sort_column, $sort_order;
                        if ($sort_column === $column) {
                            return $sort_order === 'asc' ? '↑' : '↓';
                        }
                        return '';
                    }
                    ?>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=id&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">ID <?php echo sortingArrow('id'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=first_name&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">First Name <?php echo sortingArrow('first_name'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=last_name&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Last Name <?php echo sortingArrow('last_name'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=email&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Email <?php echo sortingArrow('email'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=position&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Position <?php echo sortingArrow('position'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=team&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Team <?php echo sortingArrow('team'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=manager&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Manager <?php echo sortingArrow('manager'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=hire_date&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Hire Date <?php echo sortingArrow('hire_date'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="?sort=termination_date&order=<?php echo $opposite_order; ?>&search=<?php echo htmlspecialchars($search_query); ?>">Termination Date <?php echo sortingArrow('termination_date'); ?></a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($employees as $row) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['position']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['team']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php 
                            if ($row['manager']) {
                                echo htmlspecialchars($row['manager_first_name'] . ' ' . $row['manager_last_name']);
                            } else {
                                echo 'None';
                            }
                            ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['hire_date']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($row['termination_date']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="read.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900">View</a> |
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="text-green-600 hover:text-green-900">Edit</a> |
                            <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-900">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Card format for mobile view -->
    <div class="md:hidden">
        <?php foreach ($employees as $row) : ?>
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <p class="text-sm text-gray-600"><strong>ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                <p class="text-sm text-gray-600"><strong>First Name:</strong> <?php echo htmlspecialchars($row['first_name']); ?></p>
                <p class="text-sm text-gray-600"><strong>Last Name:</strong> <?php echo htmlspecialchars($row['last_name']); ?></p>
                <p class="text-sm text-gray-600"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p class="text-sm text-gray-600"><strong>Position:</strong> <?php echo htmlspecialchars($row['position']); ?></p>
                <p class="text-sm text-gray-600"><strong>Team:</strong> <?php echo htmlspecialchars($row['team']); ?></p>
                <p class="text-sm text-gray-600"><strong>Manager:</strong> 
                    <?php 
                    if ($row['manager']) {
                        echo htmlspecialchars($row['manager_first_name'] . ' ' . $row['manager_last_name']);
                    } else {
                        echo 'None';
                    }
                    ?>
                </p>
                <p class="text-sm text-gray-600"><strong>Hire Date:</strong> <?php echo htmlspecialchars($row['hire_date']); ?></p>
                <p class="text-sm text-gray-600"><strong>Termination Date:</strong> <?php echo htmlspecialchars($row['termination_date']); ?></p>
                <div class="mt-2">
                    <a href="read.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                    <a href="update.php?id=<?php echo $row['id']; ?>" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:text-red-900">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
