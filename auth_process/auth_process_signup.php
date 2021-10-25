<?php
if(isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['first_answer']) && isset($_POST['second_answer']) && isset($_POST['third_answer'])
    && isset($_POST['fourth_answer']) && isset($_POST['fifth_answer'])){
      if(!empty(trim($_POST['uname'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['first_answer'])) && !empty(trim($_POST['second_answer']))
        && !empty(trim($_POST['third_answer'])) && !empty(trim($_POST['fourth_answer'])) && !empty(trim($_POST['fifth_answer']))){
          require '../db_connection.php';
          $default_username = sha1('admin');
          $default_password = sha1('admin');
          $verify_admin = $connection->prepare("SELECT COUNT(*) FROM admin WHERE Uname = :username AND Password = :password");
          $verify_admin->bindParam(':username', $default_username);
          $verify_admin->bindParam(':password', $default_password);
          $verify_admin->execute();
          $still_admin = $verify_admin->fetchColumn();
          if($still_admin > 0){
              $username = sha1(trim($_POST['uname']));
              $password = sha1($_POST['password']);
              $store_credentials = $connection->prepare("UPDATE admin SET Uname = :username, Password = :password WHERE Uname = :uname AND Password = :pass");
              $store_credentials->bindParam(':username', $username);
              $store_credentials->bindParam(':password', $password);
              $store_credentials->bindParam(':uname', $default_username);
              $store_credentials->bindParam(':pass', $default_password);
              $store_credentials->execute();
              if($store_credentials->rowCount() > 0){
                $first_answer = sha1(strtolower(preg_replace('/\s+/', '', $_POST['first_answer'])));
                $second_answer = sha1(strtolower(preg_replace('/\s+/', '', $_POST['second_answer'])));
                $third_answer = sha1(strtolower(preg_replace('/\s+/', '', $_POST['third_answer'])));
                $fourth_answer = sha1(strtolower(preg_replace('/\s+/', '', $_POST['fourth_answer'])));
                $fifth_answer = sha1(strtolower(preg_replace('/\s+/', '', $_POST['fifth_answer'])));
                $question_one = $connection->prepare("UPDATE questions SET Answer = :answer_one WHERE QuestionId = 1");
                $question_two = $connection->prepare("UPDATE questions SET Answer = :answer_two WHERE QuestionId = 2");
                $question_three = $connection->prepare("UPDATE questions SET Answer = :answer_three WHERE QuestionId = 3");
                $question_four = $connection->prepare("UPDATE questions SET Answer = :answer_four WHERE QuestionId = 4");
                $question_five = $connection->prepare("UPDATE questions SET Answer = :answer_five WHERE QuestionId = 5");
                $question_one->bindParam(':answer_one', $first_answer);
                $question_two->bindParam(':answer_two', $second_answer);
                $question_three->bindParam(':answer_three', $third_answer);
                $question_four->bindParam(':answer_four', $fourth_answer);
                $question_five->bindParam(':answer_five', $fifth_answer);
                $question_one->execute();
                $question_two->execute();
                $question_three->execute();
                $question_four->execute();
                $question_five->execute();
                if($question_one->rowCount() > 0 && $question_two->rowCount() > 0 && $question_three->rowCount() > 0 && $question_four->rowCount() > 0 && $question_five->rowCount() > 0){
                  $connection = null;
                  echo "success";
                }
                else{
                  $store_credentials->bindParam(':uname', $username);
                  $store_credentials->bindParam(':pass', $password);
                  $store_credentials->bindParam(':username', $default_username);
                  $store_credentials->bindParam(':password', $default_password);
                  $store_credentials->execute();
                  if($store_credentials->rowCount() > 0){
                    $connection = null;
                    echo "reset";
                  }
                  else{
                    $connection = null;
                    echo "severe";
                  }
                }
              }
          }
          else{
            $connection = null;
            echo "changed";
          }
      }
}
?>
