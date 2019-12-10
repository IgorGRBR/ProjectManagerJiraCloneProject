<?php

$href_user_page = "form/user/";
$href_task_page = "form/task/";

$user = $data;
?>
<html>
    <head>
        <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/public/css/style.css" />
        <script src="/public/js/jquery.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-inverse p-0">
    <div class="container">
        <div class="navbar-header">
            <a href="/"><img class="brand_img" src="" width="303" height="75" alt=""></a>
        </div>
        <div class="col-8">
            <div class="container">
                <div class="d-flex">
                    <div class="ml-auto p-2">
                        <form method="POST" action="form/sign/out/">
                            <button class="btn btn-outline-light btn-md" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
        <br>
        <div class="container">
            <h4>Welcome <?=$user["login"]?>!<h4>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Piority</th>
                    <th scope="col">Requester</th>
                    <th scope="col">Owners</th>
                    <th scope="col">Open</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($user["owns"] as $task) { ?>
                    <tr>
                    <td scope="row"><?=$task['name']?></td>
                    <td><?=$task["type"]?></td>
                    <td><?=$task["priority"]?></td>

                    <td>
                    <?php
                    $i = 0;
                    if($task["requester"] != NULL) {
                    $len = $task["requester"] ;
                    
                        foreach($task["requester"] as $o) { 
                                foreach($o as $k=>$v) { 
                        ?>
                            <a href="<?=$href_user_page . "?user=" . array_keys ($o)[0]?>"><?=$o[array_keys ($o)[0]]?></a>
                        <?php 
                            ++$i;
                            } 
                        }
                    }
                    ?>
                    </td>
                    <td>
                    <?php 
                    $i = 0;
                    if($task["owners"] != NULL) {
                    $len = count($task["owners"]);
                    
                        foreach($task["owners"] as $o) { 
                            foreach($o as $k=>$v) { 
                        ?>
                            <a href="<?=$href_user_page . "?user=" . $k?>"><?=$v?></a><?= empty($task["owners"]) || $i === $len - 1? "" : ","?>
                        <?php 
                            ++$i;
                        } 
                    }
                    }
                    ?>
                    </td>
                    <td><a href="<?=$href_task_page . "?task=" . $task["id"]?>">O</a></td>
                <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer class="bg-dark text-secondary footer">
    <div class="container">
        <div class="row">
            <div class="mt-12 col-12 text-center">
                <p class="mb-0">© 2019 JiraClone</p>
                <p>Розроблено HungryStudents</p>
            </div>
        </div>
    </div>
</footer>
    </body>
</html>