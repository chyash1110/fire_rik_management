<?php
include 'config.php';

if(isset($_POST['service_id'])) {
    $serviceId = $_POST['service_id'];
    $query = "SELECT ts.*, u.username AS provider_name, u.location AS provider_location, u.contact AS contact
              FROM transportation_services ts
              JOIN users u ON ts.provider_id = u.id
              WHERE ts.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        $html = "<p>Service Name: " . $service['service_name'] . "</p>";
        $html .= "<p>Fare Details: " . $service['details'] . "</p>";
        $html .= "<p>Provider Name: " . $service['provider_name'] . "</p>";
        $html .= "<p>Provider Location: " . $service['provider_location'] . "</p>";
        $html .= "<p>Provider Contact: " . $service['contact'] . "</p>";
        echo $html;
    } else {
        echo "No service found for the selected ID.";
    }
} else {
    echo "No service ID provided.";
}
?>
