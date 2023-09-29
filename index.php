<?php
session_start();
//session_destroy();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}


if (isset($_SESSION['history_json'])) {
    $_SESSION['history'] = json_decode($_SESSION['history_json'], true);
}


if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = [
        'correct' => 0,
        'wrong' => 0,
    ];
}


if (isset($_POST['userAnswer'])) {
    
    $num1 = isset($_SESSION['num1']) ? $_SESSION['num1'] : rand(1, 50);
    $num2 = isset($_SESSION['num2']) ? $_SESSION['num2'] : rand(1, 50);
    $correctAnswer = $num1 + $num2;

    $userAnswer = $_POST['userAnswer'];

    
    if ($userAnswer == $correctAnswer) {
        $result = "Correct!  $num1 + $num2 is $correctAnswer.";
        $_SESSION['score']['correct']++;
    } else {
        $result = " your answer is wrong. The answer is $correctAnswer.";
        $_SESSION['score']['wrong']++;
    }

    
    $historyItem = [
        'num1' => $num1,
        'num2' => $num2,
        'userAnswer' => $userAnswer,
        'result' => $result,
    ];


    $_SESSION['history'][] = $historyItem;

    
    $_SESSION['history_json'] = json_encode($_SESSION['history']);

    
    $_SESSION['num1'] = rand(1, 50);
    $_SESSION['num2'] = rand(1, 50);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <form method="post" action="">
    <label for="userAnswer">What is <?php echo $_SESSION['num1']; ?> + <?php echo $_SESSION['num2']; ?>?</label>
        <input type="text" id="userAnswer" name="userAnswer" required>
        <button type="submit">Submit</button>
    </form>

    <h2>Score</h2>
    <table>
        <tr>
            <th>Correct</th>
            <th>Wrong</th>
        </tr>
        <tr>
            <td><?php echo $_SESSION['score']['correct']; ?></td>
            <td><?php echo $_SESSION['score']['wrong']; ?></td>
        </tr>
    </table>
    
    <h2>History</h2>
    <table>
        <tr>
            <th>Number 1</th>
            <th>Number 2</th>
            <th>User Answer</th>
            <th>Result</th>
        </tr>
        <?php
        foreach ($_SESSION['history'] as $item) {
            echo "<tr>";
            echo "<td>{$item['num1']}</td>";
            echo "<td>{$item['num2']}</td>";
            echo "<td>{$item['userAnswer']}</td>";
            echo "<td>{$item['result']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>