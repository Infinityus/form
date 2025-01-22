<?php
session_start();
require 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['device_token'])) {
    header("Location: login.php");
    exit();
}

// Set the title for the login page
$title = 'Earn RMS | Work from Home - Best ';

// Fetch the device token from the database
$user_id = $_SESSION['user_id'];
$stmt = mysqli_prepare($conn, "SELECT device_token FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $db_device_token);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Verify the device token
if ($_SESSION['device_token'] !== $db_device_token) {
    // Log out the user
    session_destroy();
    header("Location: login.php?error=invalid_session");
    exit();
}

// Fetch user's first name from the database
$stmt_user = mysqli_prepare($conn, "SELECT first_name FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt_user, "i", $user_id);
mysqli_stmt_execute($stmt_user);
mysqli_stmt_bind_result($stmt_user, $first_name);
mysqli_stmt_fetch($stmt_user);
mysqli_stmt_close($stmt_user);
?>
<?php include 'includes/head.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Form Filling - Multi-Step</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentStep = 0;

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((stepElement, index) => {
                stepElement.classList.add('hidden');
                if (index === step) {
                    stepElement.classList.remove('hidden');
                }
            });

            document.getElementById('prev-btn').classList.toggle('hidden', step === 0);
            document.getElementById('next-btn').classList.toggle('hidden', step === steps.length - 1);
            document.getElementById('submit-btn').classList.toggle('hidden', step !== steps.length - 1);
        }

        function nextStep() {
            const steps = document.querySelectorAll('.step');
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

        
        // Adjust view when a field is focused to ensure it remains visible
        function adjustViewOnFocus(event) {
            const answersBox = document.querySelector('.sticky-answers');
            const inputField = event.target;
            const inputRect = inputField.getBoundingClientRect();
            const viewportHeight = window.innerHeight;

            if (inputRect.bottom > viewportHeight - 20) {
                // Scroll the page to bring the field into view
                window.scrollTo({
                    top: inputRect.top + window.pageYOffset - 20,
                    behavior: 'smooth',
                });
            }

            // Ensure the answer box stays in view while typing
            if (inputRect.top < answersBox.getBoundingClientRect().bottom) {
                answersBox.classList.add('sticky');
            }
        }
        
        

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);

            // Attach focus event to all input fields
            const inputs = document.querySelectorAll('input[data-field]');
            inputs.forEach(input => {
                input.addEventListener('focus', adjustViewOnFocus);
            });
        });
    </script>
    
   
    
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <?php include '1random_data.php'; ?>
            
            <!-- Multi-Step Form -->
            <div class="md:col-span-2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Fill the Form</h2>
                 <form action="report" method="post" class="space-y-4">
                    <?php
                    $fields = array_keys($answers);
                    $stepIndex = 0;

                    for ($i = 0; $i < count($fields); $i += 4) {
                        echo "<div class='step hidden'>";
                        for ($j = 0; $j < 4 && $i + $j < count($fields); $j++) {
                            $field = $fields[$i + $j];
                            echo "
                                <div>
                                    <label for='$field' class='block font-medium text-gray-600 mb-2'>" . ($i + $j + 1) . ". " . ucfirst(str_replace('_', ' ', $field)) . "</label>
                                    <input type='text' id='$field' name='$field' data-field='$field'
                                        class='w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500' required>
                                </div>
                            ";
                        }
                        echo "</div>";
                    }
                    
                    // Pass generated data as hidden fields
                    foreach ($answers as $key => $value) {
                        echo "<input type='hidden' name='generated_$key' value='" . htmlspecialchars($value, ENT_QUOTES) . "'>";
                    }
                    
                    ?>
                    <div class="flex justify-between mt-4">
                        <button type="button" id="prev-btn" onclick="prevStep()" class="bg-gray-500 text-white px-6 py-2 rounded-md shadow-md hidden">Previous</button>
                        <button type="button" id="next-btn" onclick="nextStep()" class="bg-blue-500 text-white px-6 py-2 rounded-md shadow-md">Next</button>
                        <button type="submit" id="submit-btn" class="bg-green-500 text-white px-6 py-2 rounded-md shadow-md hidden">Submit</button>
                    </div>
                </form>

                
            </div>
        </div>
    </div>
</body>
</html>
