<?php
require './vendor/autoload.php';
use QL\QueryList;

$pages = $_GET['value'];
$bsn="60030";
$html=file_get_contents('https://forum.gamer.com.tw/B.php?page='.$pages.'&bsn='.$bsn);

$rules=[
    'title'=>['.b-list__row .b-list__main .b-list__main__title','text'],
    'link'=>['.b-list__row .b-list__main>a','href','',function($v){
        $baseUrl = 'https://forum.gamer.com.tw/';
        return $baseUrl.$v;
    }],
    'pages'=>['.b-list__row .b-list__count__number','text'],
    'post'=>['.b-list__row .b-list__count__user','text'],
    'last'=>['.b-list__row .b-list__time__edittime','text'],
    'who'=>['.b-list__row .b-list__time__user','text'],
    'mark'=>['.b-list__row .b-mark','title']
];
$data = QueryList::html($html)
        ->rules($rules)
        ->query()
        ->getData();

$dataAll=$data->all();

$db=mysqli_connect('localhost','root','','demo');
$sql='select * from student order by id';
$re=mysqli_query($db,$sql);
$num=mysqli_num_rows($re);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <style>
        .baha-box > .row.baha-head{
            padding: .3rem;
            background-color: #51A1B4 !important;
        }
        .baha-title{
            font-size:.9rem;
        }
        .baha-title a{
            color:#000;
        }
        .baha-title a:hover{
            text-decoration: none;
        }
        .baha-who{
            font-size: .8rem;
        }
        .baha-box .baha-row:nth-child(even){
            background-color: #F3F3F3;
        }
        .baha-box .baha-row.b-list__row--sticky{
            background-color: #ECF8DF;
        }
        .baha-box .baha-row.b-list__row--sticky{
            color: #777777;
        }
        .baha-box .baha-row:hover{
            background-color: #FFFFDD;
        }
        .add-btn{
            cursor: pointer;
        }
        .baha-btn-group .btn{
            background-color: #117E96;
            color:#fff;
            font-size: .6rem;
            padding: .3rem .5rem;
        }
    </style>
</head>
<body>
    <div class="container baha-box">
        <div class="row">
            <div class="col-12">
                <form action="01.insert.php" method="GET">
                    <div class="row">
                        <div class="col">
                            <input type="text" id="name" class="form-control" name="name" placeholder="name">
                        </div>
                        <div class="col">
                            <input type="text" id="age" class="form-control" name="age" placeholder="age">
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-primary" type="submit">submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for($i=0;$i<$num;$i++){
                                $row=mysqli_fetch_assoc($re);
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><a href="01.delete.php?id=<?php echo $row['id']; ?>">X</a></td>
                        </tr>
                        <?php } mysqli_close($db); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form class="tweet-box">
                    <textarea name="textMsg" cols="30" rows="10" class="form-control"></textarea>
                    <input disabled type="submit" name="tweet" value="Tweet" class="btn btn-outline-success btn-text">
                </form>
            </div>
        </div>
        <div class="row baha-head align-items-center" name="bahaHead">
            <div class="col-8 baha-btn-group">
                <span class="btn">GP 推薦</span>
                <span class="btn">精華</span>
                <span class="btn">達人</span>
            </div>
            <div class="col-2 text-center text-white" style="font-size:.6rem;">回覆 / 人氣</div>
            <div class="col-2 text-center text-white" style="font-size:.6rem;">最後發表</div>
        </div>
        <?php foreach($dataAll as $v){ ?>
            <div class="row baha-row align-items-center py-1" data-title="<?= $v['mark'] ?>">
                <div class="col-8 baha-title">
                    <a href="<?=$v['link']?>"><?php echo $v['title'] ?></a>
                </div>
                <div class="col-2">
                    <div class="d-flex flex-column baha-who justify-content-center align-items-center">
                        <span><?php echo $v['pages'] ?></span>
                        <a href="javascript:;"><?php echo $v['post'] ?></a>
                    </div>
                </div>
                <div class="col-2">
                    <div class="d-flex flex-column baha-who justify-content-center align-items-center">
                        <span><?php echo $v['last'] ?></span>
                        <a href="javascript:;"><?php echo $v['who'] ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center align-items-center">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            var i=0;
            $('.add-btn').on('click',function(){
                i++;
                location.href="01.php?value="+i;
            })
            $('.baha-row').each(function(){
                if($(this).data('title').length > 0){
                    $(this).addClass("b-list__row--sticky")
                }
            })
            var form=$('.tweet-box')[0];
            $(form.textMsg).on('input',function(){
                form.tweet.disabled=this.value.length <= 0;
            }).trigger('input')
        })
    </script>
</body>
</html>