<?php
// Utility functions for the Civic Sense application

// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ?page=login');
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header('Location: ?page=home');
        exit();
    }
}

// User functions
function registerUser($username, $email, $password, $fullName) {
    global $pdo;
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$username, $email, $hashedPassword, $fullName]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function loginUser($username, $password) {
    global $pdo;
    
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];
        return true;
    }
    
    return false;
}

function logoutUser() {
    session_destroy();
    header('Location: ?page=home');
    exit();
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    global $pdo;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

// Problem functions
function getAllProblems($category = null, $search = null) {
    global $pdo;
    
    $sql = "SELECT p.*, u.username as author_name FROM problems p 
            LEFT JOIN users u ON p.user_id = u.id";
    $params = [];
    
    if ($category) {
        $sql .= " WHERE p.category = ?";
        $params[] = $category;
    }
    
    if ($search) {
        $sql .= $category ? " AND" : " WHERE";
        $sql .= " (p.title LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    $sql .= " ORDER BY p.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getProblemById($id) {
    global $pdo;
    
    $sql = "SELECT p.*, u.username as author_name FROM problems p 
            LEFT JOIN users u ON p.user_id = u.id WHERE p.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createProblem($title, $description, $category, $location) {
    global $pdo;
    
    $sql = "INSERT INTO problems (title, description, category, location, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$title, $description, $category, $location, $_SESSION['user_id']]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

// Solution functions
function getSolutionsByProblemId($problemId) {
    global $pdo;
    
    $sql = "SELECT s.*, u.username as author_name FROM solutions s 
            LEFT JOIN users u ON s.user_id = u.id 
            WHERE s.problem_id = ? ORDER BY s.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$problemId]);
    return $stmt->fetchAll();
}

function createSolution($problemId, $title, $description, $source) {
    global $pdo;
    
    $sql = "INSERT INTO solutions (problem_id, title, description, source, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$problemId, $title, $description, $source, $_SESSION['user_id']]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

// Forum functions
function getAllForumPosts($category = null, $search = null) {
    global $pdo;
    
    $sql = "SELECT fp.*, u.username as author_name, 
            (SELECT COUNT(*) FROM comments c WHERE c.post_id = fp.id) as comment_count,
            (SELECT COUNT(*) FROM likes l WHERE l.post_id = fp.id) as like_count
            FROM forum_posts fp 
            LEFT JOIN users u ON fp.user_id = u.id";
    $params = [];
    
    if ($category) {
        $sql .= " WHERE fp.category = ?";
        $params[] = $category;
    }
    
    if ($search) {
        $sql .= $category ? " AND" : " WHERE";
        $sql .= " (fp.title LIKE ? OR fp.content LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    $sql .= " ORDER BY fp.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getForumPostById($id) {
    global $pdo;
    
    $sql = "SELECT fp.*, u.username as author_name FROM forum_posts fp 
            LEFT JOIN users u ON fp.user_id = u.id WHERE fp.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createForumPost($title, $content, $category) {
    global $pdo;
    
    $sql = "INSERT INTO forum_posts (title, content, category, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$title, $content, $category, $_SESSION['user_id']]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

// Comment functions
function getCommentsByPostId($postId) {
    global $pdo;
    
    $sql = "SELECT c.*, u.username as author_name FROM comments c 
            LEFT JOIN users u ON c.user_id = u.id 
            WHERE c.post_id = ? ORDER BY c.created_at ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);
    return $stmt->fetchAll();
}

function createComment($postId, $content) {
    global $pdo;
    
    $sql = "INSERT INTO comments (post_id, content, user_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$postId, $content, $_SESSION['user_id']]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

// Like functions
function toggleLike($postId) {
    global $pdo;
    
    if (!isLoggedIn()) return false;
    
    $sql = "SELECT id FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id'], $postId]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // Unlike
        $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $postId]);
        return 'unliked';
    } else {
        // Like
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $postId]);
        return 'liked';
    }
}

function isLikedByUser($postId) {
    if (!isLoggedIn()) return false;
    
    global $pdo;
    $sql = "SELECT id FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id'], $postId]);
    return $stmt->fetch() ? true : false;
}

// Contact and issue reporting functions
function submitContact($name, $email, $subject, $message) {
    global $pdo;
    
    $sql = "INSERT INTO contact_submissions (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$name, $email, $subject, $message]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function submitIssueReport($title, $description, $location, $category, $priority) {
    global $pdo;
    
    $sql = "INSERT INTO issue_reports (title, description, location, category, priority, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$title, $description, $location, $category, $priority, $_SESSION['user_id']]);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

// Utility functions
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function getProblemCategories() {
    return [
        'road_discipline' => 'Road Discipline',
        'transport_stations' => 'Railway & Bus Stations',
        'student_behavior' => 'Student Behavior',
        'cleanliness' => 'Cleanliness Issues',
        'event_management' => 'Event Management',
        'citizen_education' => 'Citizen Education',
        'public_toilets' => 'Public Toilets',
        'climate_change' => 'Climate Change',
        'travel_issues' => 'Travel Issues'
    ];
}

function getPriorityLevels() {
    return [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent'
    ];
}
?>
