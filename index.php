<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet">
    <title>Hotel Booking App</title>
</head>
<body>

    <h1>Welcome to your personal Hotel Booking App</h1>
    <h3>Where would you like to stay:</h3>
    <?php

        $sql = "CREATE TABLE bookings (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50),
        surname VARCHAR(50),
        hotelname VARCHAR(50),
        indate VARCHAR(30),
        outdate VARCHAR(30)
        )";

    require_once 'connect.php';
    $conn->query($sql);
    echo $conn->error;

?>
    <form class="form-inline" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br><br>
            <label for="surname">Last Name:</label>
            <input type="text" id="surname" name="surname" required><br><br>
            <label for="start">Check-In Date:</label>
            <input type="date" id="start" name="indate" min="2019-05-06" max="2019-12-31" required><br><br>
            <label for="end">Check-Out Date:</label>
            <input type="date" id="end" name="outdate" min="2019-05-08" max="2020-01-31"required><br><br>
            <select name="hotelname" required>
                <option value="The Cape Town Hotel">The Cape Town Hotel</option>
                <option value="Club Med">Club Med</option>
                <option value="The One & Only Hotel">The One & Only Hotel</option>
                <option value="De Zelze Hotel and Spa">De Zelze Hotel and Spa</option>
                <option value="The Stay Easy">The Stay Easy</option>
            </select>
            <br><br>
            <button type="submit" name="submit">Lets See If Its Available!</button>
    </form>


    <div class = "container">   
        <?php

            if(isset($_POST['submit'])){
                $_SESSION['firstname'] = $_POST['firstname'];
                $_SESSION['surname'] = $_POST['surname'];
                $_SESSION['indate'] = $_POST['indate'];
                $_SESSION['outdate'] = $_POST['outdate'];
                $_SESSION['hotelname'] = $_POST['hotelname'];

                $datetime1 = new DateTime($_SESSION['indate']);
                $datetime2 = new DateTime($_SESSION['outdate']);
                $interval = $datetime1->diff($datetime2);
                //NUMBER OF DAYS BOOKED:
                $daysBooked = $interval->format('%R%a');
                //BOOKING COST PLACE HOLDER:
                $value;
        
                //ADJUSTMENT FOR THE DIFFERENT PRICES FOR THE DIFFERENT HOTELS - USE SWITCH:
                switch($_POST['hotelname']){
                    case "The Cape Town Hotel" :
                        $value = $daysBooked * 1100;
                        break;
                    case "Club Med" :
                        $value = $daysBooked * 1300;
                        break;
                    case "The One & Only Hotel" :
                        $value = $daysBooked * 4300;
                        break;
                    case "De Zelze Hotel and Spa" :
                        $value = $daysBooked * 2200;
                        break;
                    case "The Stay Easy" :
                        $value = $daysBooked * 900;
                        break;
                    default :
                        echo "Invalid booking.";
                }
                
                //BOOKING INFO DISPLAYED TO USER BEFORE CONFIRMATION:
                echo "<div class='one'>";
                echo "<br> First Name : " . $_SESSION['firstname'] . "<br>" . "Surname : " . $_SESSION['surname'] . "<br>" . "Hotel Name : " . $_SESSION['hotelname'] . "<br>" . "Check-In Date : " . $_SESSION['indate'] . "<br>" . "Check-Out Date : " . $_SESSION['outdate'] . "<br>" . $interval->format("%R%a days") . "<br>" . "Total : " . $value . "<br>";
                echo "<br> <button class='submit2'>Confirm Booking</button>";
                echo "</div>";
                
            } 

            $firstname = $_SESSION['firstname'];
            $surname = $_SESSION['surname'];
            $hotelname = $_SESSION['hotelname'];
            $indate = $_SESSION['indate'];
            $outdate = $_SESSION['outdate'];


            if($_POST){
            $sql = "INSERT INTO bookings (firstname, surname, hotelname, indate, outdate)
            VALUES('$firstname','$surname','$hotelname','$indate','$outdate')";

                    //IF BOOKING IS CONFIRMED, ECHO OUT TO USER:
                    if($conn->query($sql) === TRUE) {
                        echo "Your Booking Has Been Confirmed, Enjoy Your Stay!";
                        }else{
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                        }
                    

        ?>
    </div>

            <div class="book-con"></div>
            <script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script type = "text/javascript" src ="main.js"></script>
</body>
</html>