<?php
// Hello! I'm going to do pointless things. Don't mind me.
$todos = [];

if (file_exists('todos.txt')) {
    $todosBef   = file_get_contents('todos.txt');
    $todos      = unserialize($todosBef);
}

if (isset($_POST['add'])) {
    $dataTodo = $_POST['todo'];
    $todos [] = [
        'todo'      => $dataTodo,
        'status'    => 0
    ];

    simpan($todos);
}

if (isset($_GET['status'])) {
    $todos[$_GET['key']]['status'] = $_GET['status'];
    simpan($todos);
}

if (isset($_GET['hapus'])) {
    unset($todos[$_GET['key']]);
    simpan($todos);
}

function simpan($todos) {
    $listTodo = serialize($todos);
    file_put_contents('todos.txt', $listTodo);
    header('location: index.php');
}

// print_r($todos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO APP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1 class="todo">TODO</h1><h1 class="app"> App</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <form action="" method="POST">
            <label for="todo">What will you do today?</label><br>
            <input type="text" name="todo" id="todo" placeholder="type here..."><br>
            <button type="submit" name="add" id="add">Add</button>
        </form>

        <!-- List data | What to do -->
        <p id="line">------------------------------</p>
        <table align="center">
            <tr>
                <td>
                    <ul class="dataTodo">
                        <?php foreach($todos as $key => $value) { ?>
                        <li>
                            <input type="checkbox" name="check" class="check"
                            onclick="window.location.href='index.php?status=<?php echo($value['status']==1)?'0':'1'; ?>&key=<?php echo $key; ?>'"
                            <?php if ($value['status']==1) { echo 'checked'; } ?>>

                            <label>
                            <?php
                            if ($value['status']==1) {
                                echo '<del>'.$value['todo'].'</del>';
                            }
                            else {
                                echo $value['todo'];
                            }
                            ?>
                            </label>

                            <a href="index.php?hapus=1&key=<?php echo $key; ?>" class="delete"
                            onclick="return confirm('Hapus <?php echo $value['todo']; ?> dari list?')">
                                Delete
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>