<?php
// Start the session if it's not already started
if (!isset($_SESSION)) {
    session_start();
}
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="jumbotron.css" rel="stylesheet">
<?php
include("header.php");
include("library.php");

// Functions to restrict access for different user roles
noAccessForDoctor();
noAccessForNormal();
noAccessForAdmin();
noAccessIfNotLoggedIn();

include('nav-bar.php');
?>

<div class="container">
    <h2>All Appointments</h2>
    <p>Click on the field to fill in additional information</p>

    <table class="table table-striped text-center">
        <thead class="thead-inverse">
            <tr>
                <th><center>Appointment No</center></th>
                <th><center>Patient's Full Name</center></th>
                <th><center>Medical Condition</center></th>
                <th><center>Doctor Needed</center></th>
            </tr>
        </thead>
        <?php
        // Retrieve all appointments
        $result = getAllAppointments();

        // Function to render table rows for appointments
        function renderTable($row)
        {
            $status = ' ';
            $appointmentNo = (int)$row['appointment_no'];

            // Determine appointment status and apply appropriate CSS class
            if (appointment_status($appointmentNo) == 1) {
                $status = "table-active";
            } else if (appointment_status($appointmentNo) == 2) {
                $status = "table-success";
            }

            $link = "<td><a href='payment.php?appointment_no=$appointmentNo'>";
            $endingTag = "</a></td>";

            echo "<tr class=\"$status\">";
            echo "$link" . $row['appointment_no'] . "$endingTag";
            echo "$link" . $row['full_name'] . "$endingTag";
            echo "$link" . $row['medical_condition'] . "$endingTag";
            echo "$link" . $row['speciality'] . "$endingTag";
            echo "</tr>";
        }

        while ($row = $result->fetch_array()) {
            renderTable($row);
        }
        ?>
    </table>
</div>

<?php include("footer.php"); ?>
