<?php
require 'lib.php';
//____________________________________________
function show_last_seq($user_id, $firstname, $lastname, $event_seq=-1){
  $user = select_user_attr($user_id);
  foreach($user as $row){
        echo "row -> $row<br>";
    foreach($row as $k => $v){
      echo "$k => $v<br>";
      if ($k == 'LastName'){
        $last_name = $v;
      } elseif ($k == 'FirstName'){
        $first_name = $v;
      }
    }
  }
  if ($firstname == $first_name and $last_name ==$lastname){
    $rows = select_user($user_id, $event_seq);
  } else {
    die("Your information mismatched our records. Please, fix and <a href='contact.php?user_id=$user_id'>try again</a><p>Thank you!");
  }
}
?>
