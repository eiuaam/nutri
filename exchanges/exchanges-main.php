<?php
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/nutri/sessions/auth_session.php';
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/nutri/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$username = mysqli_real_escape_string($conn, $username);

// Initialize variables
$selectedTER = '';  // Default value
$ter = '';         // Default value

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch necessary user information from the database
    $query = "SELECT age, weight, dbw_bmi, dbw_hamwi, dbw_tann, pal, harris, mifflin, oxford FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $age = $row['age'];
            $userWeight = $row['weight'];

            // Determine which DBW value to display based on the selected option
            $selectedTER = isset($_POST['ter']) ? $_POST['ter'] : ''; // Check if 'ter' is set in the POST data
            switch ($selectedTER) {
                case 'pal':
                    $ter = $row['pal'];
                    break;
                case 'harris':
                    $ter = $row['harris'];
                    break;
                case 'mifflin':
                    $ter = $row['mifflin'];
                    break;
                case 'oxford':
                    $ter = $row['oxford'];
                    break;
                default:
                    $ter = ''; // Set a default value or handle as needed
            }
        }
    } else {
        die("Error in query: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="exchanges-design.css" />

    <title>Distribution of Exchanges</title>
</head>

<body>
    <div class="container">
        <label for="ter">Choose TER (kcal):</label>
        <form method="post" action="">
            <select name="ter" id="ter">
                <!--  <option value="empty"></option>-->
                <option value="pal" <?php if ($selectedTER === 'pal')
                    echo 'selected'; ?>>PAL</option>
                <option value="harris" <?php if ($selectedTER === 'harris')
                    echo 'selected'; ?>>Harris</option>
                <option value="mifflin" <?php if ($selectedTER === 'mifflin')
                    echo 'selected'; ?>>Mifflin</option>
                <option value="oxford" <?php if ($selectedTER === 'oxford')
                    echo 'selected'; ?>>Oxford</option>
            </select>
            <button type="submit">Submit</button>
        </form>


        <p> Dietary Prescription: </p>

        <table>
            <tr>
                <td> Kcal: </td>
                <td id="kcalOutput"></td>
            </tr>

            <tr>
                <td>Carbs: </td>
                <td id="carbsOutput"></td>
            </tr>
            <tr>
                <td>Protein: </td>
                <td id="proteinOutput"></td>
            </tr>
            <tr>
                <td>Fat: </td>
                <td id="fatOutput"></td>
            </tr>
        </table>

        <form id="diet-presc" method="post" action="save_main.php">
            <input type="hidden" name="diet-desc" id="diet-descInput" value="">
            <button type="button" id="calculate" onclick="calculateTER()">Calculate</button>
            <button type="button" id="save">Save</button>
            <button type="button" class="button button-back" id="back">Back to Dashboard</button>
        </form>
    </div>


    <script>
        function calculateTER() {
            // Get the selected TER value from the dropdown
            var selectedTER = document.getElementById("ter").value;

            // Get the total caloric intake from the server-side code (assumed to be stored in the 'ter' variable)
            var kcal = parseFloat(<?php echo $ter; ?>); // No need for json_encode

            // Calculate macronutrient amounts based on caloric distribution
            var carbs = (kcal * 0.65) / 4;
            var protein = (kcal * 0.15) / 4;
            var fat = (kcal * 0.20) / 9;

            // Display or use the calculated values as needed
            document.getElementById("diet-descInput").value = "Carbs: " + carbs + ", Protein: " + protein + ", Fat: " + fat;

            // Update the table cells with the calculated values
            document.getElementById("carbsOutput").textContent = carbs.toFixed(2);
            document.getElementById("proteinOutput").textContent = protein.toFixed(2);
            document.getElementById("fatOutput").textContent = fat.toFixed(2);
        }

        // Button event handler for going back to the dashboard
        document.getElementById('back').addEventListener('click', function () {
            // Redirect the user to the dashboard page
            window.location.href = '../user_main_page.php'; // Adjust the path as needed
        });

    </script>

</body>

</html>