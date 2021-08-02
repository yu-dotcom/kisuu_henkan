<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>基数変換機</title>
</head>
<body>
    <h1>基数変換機</h1>
    <a href="https://github.com/yu-dotcom/kisuu_henkan/blob/main/index.php" class="source" target="_blank">ソースコード(GitHub)</a>
    <form action="./index.php" method="POST" class="form">
        <p>入力した
            <select name="before">
                <option value="10">10進数</option>
                <option value="2">2進数</option>
                <option value="8">8進数</option>
                <option value="16">16進数</option>
            </select>
            を
            <select name="after">
                <option value="10">10進数</option>
                <option value="2">2進数</option>
                <option value="8">8進数</option>
                <option value="16">16進数</option>
            </select>
            に変換します。
        </p>
        <p>入力値:<input type="text" name="num"></p>
        <input type="submit" name="submit" value="変換">
    </form>
    <?php

    /*
    *$strが2進数として相応しい文字列か確認する関数
    *$strが1か0のみで構成されていればtrue,それ以外の文字を含む場合false
    */
    function is_bin($str){
        if (preg_match("/[^0-1]/", $str)) {
            return false;
        }
        return true;
    }

    /*
    *$strが8進数として相応しい文字列か確認する関数
    *$strが0～7のみで構成されていればtrue,それ以外の文字を含む場合false
    */
    function is_octal($str){
        if (preg_match("/[^0-7]/", $str)) {
            return false;
        }
        return true;
    }

    /*
    *$strが10進数として相応しい文字列か確認する関数
    *$strが0～9のみで構成されていればtrue,それ以外の文字を含む場合false
    */
    function is_dec($str){
        if (preg_match("/[^0-9]/", $str)) {
            return false;
        }
        return true;
    }

    /*
    *$strがn進数として相応しい場合true,そうではない場合false
    */
    function is_n_num($str, $n){
        if($n == '2'){
            return is_bin($str);
        }else if($n == '8'){
            return is_octal($str);
        }else if($n == '10'){
            return is_dec($str);
        }else if($n == '16'){
            return ctype_xdigit($str);
        }else {
            return false;
        }
    }

    $err_message = array();

    if(isset($_POST['submit'])){
        $num = $_POST['num'];
        $before = $_POST['before'];
        $after = $_POST['after'];

        $base_num_arr = array('10','2','8','16');
        
        if(empty($num)){
            $err_message[] = '入力値を入力して下さい。';
        }
        
        for($i = 0;$i < count($base_num_arr);$i++){
            for($j = 0;$j < count($base_num_arr);$j++){
                $is_ans = $base_num_arr[$i] == $before && $base_num_arr[$j] == $after;
                if($is_ans && is_n_num($num,$before)){
                    $ans = base_convert($num, $before, $after);
                    break;
                }else if(!is_n_num($num,$before)){
                    $err_message[] = '不正な値が入力されました。';
                    break;
                }
            }
            if(isset($ans) || !empty($err_message)){
                break;
            }
        }
    }
    if(isset($ans)){
        echo '<p class="answer">' . $before . '進数から' . $after . '進数へ変換しました => ';
        echo '<p class="answer">' . $ans . '</p>';
    }
    foreach($err_message as $err){
        echo '<p class="err-message">' . $err . '</p>';
    }
        
    ?>
</body>
</html>
