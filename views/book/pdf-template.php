<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $books app\models\Book[] */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book List</title>
    <style>
        /* Add your styles here for PDF formatting */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h1>Book List</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Published Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book) : ?>
                <tr>
                    <td><?= Html::encode($book->id) ?></td>
                    <td><?= Html::encode($book->title) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>