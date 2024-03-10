<?php
// display the table if the number of users retrieved was greater than zero
if($num>0){
    echo "<table class='table table-hover table-responsive table-bordered'>";
    // table headers
    echo "<tr>";
        echo "<th>Yr & Section</th>";
        echo "<th>Class President</th>";
        echo "<th>Class Treasurer</th>";
        echo "<th>Actions</th>";
    echo "</tr>";
    // loop through the user records
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        // display user details
        echo "<tr>";
            echo "<td>{$class_year}: {$class_section}</td>";
            echo "<td>{$section_president}</td>";
            echo "<td>{$section_treasurer}</td>";
            echo "<td>";
                // buttons are here
                echo "<button class='btn btn-success'>View</button>";
            echo "</td>";
        echo "</tr>";
        }
    echo "</table>";
    $page_url="read_section.php?";
    $total_rows = $section->countAll();
    // actual paging buttons
    include_once 'paging.php';
}
// tell the user there are no selfies
else{
    echo "<div class='alert alert-danger'>
        <strong>No Section Found found.</strong>
    </div>";
}
?>