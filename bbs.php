<?php
    if(!isset($_GET["mode"]))
        $mode = "list";
    else
        $mode = $_GET["mode"];

    if($mode == "view")
    {
        if(isset($_GET["idx"]))
            $idx = $_GET["idx"];

       
        $sql = "select * from bbs where idx='$idx' ";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($result);

        if($data)
        {
            $data["content"] = nl2br($data["content"]);
                                // New Line to Br tag

            $data["title"] = str_replace("<", "&lt;", $data["title"]);
            $data["title"] = str_replace(">", "&gt;", $data["title"]);
               
            $data["content"] = str_replace("<", "&lt;", $data["content"]);
            $data["content"] = str_replace(">", "&gt;", $data["content"]);
               
            ?>
            <div class="row">
                <div class="col-2">제목</div>
                <div class="col"><?php echo $data["title"] ?></div>
            </div>
            <div class="row">
                <div class="col-2">작성자</div>
                <div class="col"><?php echo $data["name"] ?></div>
            </div>

            <div class="row" style="min-height:200px;">
                <div class="col"><?php echo $data["content"] ?></div>
            </div>

            <div class="row">
                <div class="col text-center"> 
                    <button type="button" class="btn btn-primary btn-sm" onClick="location.href='main.php?cmd=bbs'" >목록</button>
                </div>
            </div>
            <?php
        }else
        {
            ?>
                <script>
                    alert('삭제된 글입니다.');
                    location.href='main.php?cmd=bbs';
                </script>
            <?php
        }
    }
    if($mode == "list")
    {
        ?>
        <div class="row">
            <div class="col-1">순서</div>
            <div class="col-9">제목</div>
            <div class="col-2">작성자</div>
        </div>

        <?php
            $sql = "select * from bbs order by idx desc";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_array($result);

            while($data)
            {
                
                $data["title"] = str_replace("<", "&lt;", $data["title"]);
                $data["title"] = str_replace(">", "&gt;", $data["title"]);


                ?>
                <div class="row">
                    <div class="col-1"><?php echo $data["idx"] ?></div>
                    <div class="col-9"><a href="main.php?cmd=bbs&mode=view&idx=<?php echo $data["idx"] ?>"><?php echo $data["title"] ?></a></div>
                    <div class="col-2"><?php echo $data["name"] ?></div>
                </div>
                <?php
                $data = mysqli_fetch_array($result); 
            }
        ?>


        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-primary btn-sm" onClick="location.href='main.php?cmd=bbs&mode=write' ">글쓰기</button>
            </div>
        </div>

        <?php
    }
    if($mode == "dbwrite")
    {
        $title = $_POST["title"];
        $name = $_POST["name"];
        $content = $_POST["content"];

        $tilte = str_replace("<", "&lt;", $title);
        $tilte = str_replace(">", "&gt;", $title);

        $content = str_replace("<", "&lt;", $content);
        $content = str_replace(">", "&gt;", $content);

        $sql = "insert into bbs (title, name, content) 
                    values('$title', '$name', '$content')";
        $result = mysqli_query($conn, $sql);

        if($result)
            $msg = "성공";
        else    
            $msg = "실패";

        echo "
        <script>
            alert('$msg');
            location.href='main.php?cmd=bbs';
        </script>
        ";

    }
    if($mode == "write")
    {
        ?>
        <form name="bbsForm" method="POST" action="main.php?cmd=bbs&mode=dbwrite">
        <div class="row">
            <div class="col-2">제목</div>
            <div class="col">
                <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요">
            </div>
        </div>
        <div class="row">
            <div class="col-2">작성자</div>
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="작성자입력">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <textarea name="content" class="form-control" rows=10 placeholder="내용입력"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn btn-primary btn-sm" >등록</button>
                <button type="button" class="btn btn-primary btn-sm" onClick="location.href='main.php?cmd=bbs'" >목록</button>
            </div>
        </div>
        </form>
        <?php
    }
?>