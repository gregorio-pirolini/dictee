<?php

// ---------------------------------------------------
//  Change these 3 values to match your real situation
// ---------------------------------------------------
$userId    = 6;                     // ← your test user id
$level     = 'D';                   // ← try 'A','B','C','D'  (also try empty string '')
$database  = 'db1234567';           // ← your actual database name

include_once 'db_connect.php';      // keep your existing connection file

header('Content-Type: text/plain; charset=utf-8');

// Debug: show what we received
echo "Testing with:\n";
echo "  userId = $userId\n";
echo "  level  = '$level'\n\n";

// Your doLevels function (copy-paste it here)
function doLevels($letter) {
    $letter = trim(strtoupper($letter));

    if ($letter === 'A') return "w.`level` = 'A'";
    if ($letter === 'B') return "(w.`level` = 'A' OR w.`level` = 'B')";
    if ($letter === 'C') return "(w.`level` = 'A' OR w.`level` = 'B' OR w.`level` = 'C')";
    if ($letter === 'D') return "(w.`level` = 'A' OR w.`level` = 'B' OR w.`level` = 'C' OR w.`level` = 'D')";
    if ($letter === 'E') return "(w.`level` = 'A' OR w.`level` = 'B' OR w.`level` = 'C' OR w.`level` = 'D' OR w.`level` = 'E'))";
    // fallback when bad input
    return "1=1";
}

$levels = doLevels($level);

// Safety net (this is what should prevent the crash)
if (empty($levels) || $levels === 'null' || $level === 'null') {
    $levels = "1=1";
}

echo "Generated WHERE condition:\n  $levels\n\n";

// The simplest possible query (just 1 row to see if it runs)
$sql = "
    SELECT w.word, w.folder, w.id, w.level,
           wu.words_number, wu.last_asked
    FROM words w
    JOIN words_users wu ON w.id = wu.words_id
    WHERE $levels
      AND wu.user_id = :userId
    LIMIT 1
";

echo "SQL to be executed:\n$sql\n\n";

try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    echo "Query SUCCESSFUL ✓\n";
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Found example row:\n";
        print_r($row);
    } else {
        echo "No rows found (but query ran without error)";
    }
} catch (PDOException $e) {
    echo "QUERY FAILED:\n";
    echo $e->getMessage() . "\n";
    echo "\nMost likely cause → bad WHERE condition or table/column name mismatch\n";
}

$db = null;
echo "\n--- end ---\n";
?>