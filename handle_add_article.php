<?php
    require_once('conn.php');

    $subject = $_POST['subject'];
    $classify = $_POST['article_classify'];
    $content = $_POST['article_content'];

    // search classify id
    $sql_cmd = "SELECT id FROM classifies WHERE classify_name = ?";
    $stmt = $conn->prepare($sql_cmd);
    $stmt->bind_param('s', $classify);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "尋找 classify_id: ";
    var_dump($result);
    echo "<br/>";
    if($result->num_rows === 0) {
        // 建立新的 classify
        $sql_cmd = "INSERT INTO classifies(classify_name) VALUES(?)";
        $stmt->prepare($sql_cmd);
        $stmt->bind_param('s', $classify);
        $result = $stmt->execute();
        echo "建立完成新的 classify id: ";
        var_dump($result);
        echo "<br/>";

        // 找尋 classify 的 id
        $sql_cmd = "SELECT id FROM classifies WHERE classify_name = ?";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('s', $classify);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $classify_id = $row['id'];
        echo "找尋完 classify_id: ";
        echo $classify_id;
        echo "<br/>"; 

        // 將文章存進資料庫
        $sql_cmd = "INSERT INTO articles(classify_id, subject, content) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('iss', $classify_id, $subject, $content);
        $result = $stmt->execute();
        echo "文章存進資料庫內: ";
        echo $result;
        echo "<br/>";
        header("Location: index.php");
    }
    else {
        echo "之前已經有 classify_id了: ";
        // 找到 classify 的 id
        $row = $result->fetch_assoc();
        $classify_id = $row['id'];
        echo $classify_id;
        echo "<br/>";
        // 將文章存進資料庫
        $sql_cmd = "INSERT INTO articles(classify_id, subject, content) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($sql_cmd);
        $stmt->bind_param('iss', $classify_id, $subject, $content);
        $result = $stmt->execute();
        echo "文章存進資料庫內： ";
        echo $reslult;
        echo "<br/>";

        header("Location: index.php");
    }
 
?>