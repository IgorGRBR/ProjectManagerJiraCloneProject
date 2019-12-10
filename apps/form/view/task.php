<?php

$href_user_page = "form/user/";
$href_task_page = "form/task/";

$task = $data[0];
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
            <hr>
            <div class="modal-body">
                    <form class="form-group">
                        <p>Назва <small></small></p>
                        <input class="form-control btn-block" type="text" name="" required value="<?=$task['name']?>">
                        <p class="text-danger text-center mb-4"><small id=""></small></p>

                        <p>Тип</p>
                        <input class="form-control btn-block" type="text" name="" required value="<?=$task['type']?>">
                        <p class="text-danger text-center"><small id=""></small></p>

                        <p>Пріоритет</p>
                        <input class="form-control btn-block" type="text" name="" required value="<?=$task['priority']?>">
                        <p class="text-danger text-center"><small id=""></small></p>

                        <p>Опис</p>
                        <input class="form-control btn-block" type="text" name="" required value="<?=$task['description']?>">
                        <p class="text-danger text-center"><small id=""></small></p>

                        <hr>
                        <p>Виконавці</p>
                        <div>
                            <?php
                            if($task["owners"] != NULL) {
                                $len = $task["owners"] ;
                                
                                foreach($task["owners"] as $k=>$v) {?>
                                    <a href="<?=$href_user_page . "?user=" . $v['login']?>"><?=$v['login']?></a>
                            <?php 
                                    ++$i;
                                }  
                            }?>
                        </div>
                        <hr>
                        <p>Запит від</p>
                        <div>
                            <?php
                            if($task["requester"] != NULL) {
                                $len = $task["requester"] ;
                                
                                foreach($task["requester"] as $k=>$v) {?>
                                    <a href="<?=$href_user_page . "?user=" . $v['login']?>"><?=$v['login']?></a>
                            <?php 
                                    ++$i;
                                }  
                            }?>
                        </div>
                    </form>
                </div>
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