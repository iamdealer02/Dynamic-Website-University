<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "epita";

$conn = new mysqli($servername, $username, $password, $dbname);

function get_attendances() {
    global $conn;

    $sql = "SELECT p.PROGRAM_ASSIGNMENT,
    a.ATTENDANCE_POPULATION_YEAR_REF,
    (SUM(a.ATTENDANCE_PRESENCE) * 100 / COUNT(a.ATTENDANCE_PRESENCE)) AS OVERALL_ATTENDANCE
FROM ATTENDANCE a 
INNER JOIN PROGRAMS p ON a.ATTENDANCE_COURSE_REF = p.PROGRAM_COURSE_CODE_REF 
GROUP BY p.PROGRAM_ASSIGNMENT, a.ATTENDANCE_POPULATION_YEAR_REF
ORDER BY p.PROGRAM_ASSIGNMENT";

    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        die("Query execution failed: " . $conn->error);
    }
    while ($row = $result->fetch_assoc()) {
        echo ("<tr>
        <td>" . $row['PROGRAM_ASSIGNMENT'] . "</td>
        <td>" . $row['ATTENDANCE_POPULATION_YEAR_REF'] . "</td>
        <td>" . $row['OVERALL_ATTENDANCE'] . "</td>
        </tr>
        ");
    }
    return $row;
}


?>