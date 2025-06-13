<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="meal-plan.css" />
    <title>Meal Plan</title>
</head>
<body>
    <div class="container">
        <h1>Meal Plan</h1>

        <div class="meal">
            <h2>Breakfast</h2>
            <select name="breakfastDropdown">
                <option value="oatmeal">Oatmeal</option>
                <option value="eggs">Eggs</option>
                <option value="smoothie">Smoothie</option>
            </select>
        </div>

        <div class="meal">
            <h2>Lunch</h2>
            <select name="lunchDropdown">
                <option value="salad">Salad</option>
                <option value="sandwich">Sandwich</option>
                <option value="grilled-chicken">Grilled Chicken</option>
            </select>
        </div>

        <div class="meal">
            <h2>Dinner</h2>
            <select name="dinnerDropdown">
                <option value="spaghetti">Spaghetti</option>
                <option value="salmon">Salmon</option>
                <option value="stir-fry">Stir Fry</option>
            </select>
        </div>

        <div class="snacks">
            <h2>Snacks</h2>
            <select name="snacksDropdown">
                <option value="fruit">Fruit</option>
                <option value="nuts">Nuts</option>
                <option value="yogurt">Yogurt</option>
            </select>
        </div>

    <form id="diet-presc" method="post" action="save_main.php">
        <input type="hidden" name="diet-desc" id="diet-descInput" value="">
        <button type="button" id="calculate" onclick="">Button</button>
        <button type="button" id="save">Save</button>
        <button type="button" class="button button-back" id="back">Back to Dashboard</button>
    </form>

    <script>
        // Button event handler for going back to the dashboard
        document.getElementById('back').addEventListener('click', function () {
            // Redirect the user to the dashboard page
            window.location.href = '../user_main_page.php'; // Adjust the path as needed
        });
    </script>
</body>

</html>