<?php require "lib.php";
//___________________________________________________________
function get_user_attributes($user_id){
  $user = select_user_attr($user_id);
  $user_array = array();
  foreach($user as $row){
    $user_array[$row['attribute_name']] = $row['attribute_value'];
  }
  return $user_array;
}
//___________________________________________________________
function get_user_seq($user_id, $firstname, $lastname, $event_seq=-1)
{
  echo "Staring get_user_seq  $user_id, $firstname, $lastname, $event_seq . . . ";
  $user = get_user_attributes($user_id);
  $last_name = "Customer";
  if (array_key_exists('LastName', $user)) {
    $last_name = $user['LastName'];
  }
  if (array_key_exists('FirstName', $user)) {
    $first_name = $user['FirstName'];
  }
  $rows = NULL;
  if ($firstname == $first_name and $last_name ==$lastname){
    $rows = select_user($user_id, $event_seq);
  } else {
    die("Your information mismatched our records. Please, fix and <a href='contact.php?user_id=$user_id'>try again</a><p>Thank you!");
  }
  foreach ($user as $key => $value) {
    if (!is_int($key)) {
        unset($arr[$key]);
    }
  }
  foreach($rows as $k => $row){
    $r = array_replace($row, $user);
    $rows[$k] = $r;
  }
  return $rows;
}
//___________________________________________________________
function show_user_seq($user_id, $firstname, $lastname, $main_row){
  // extract($main_row);

  foreach($main_row as $k => $v) {
      echo "show_last_seq $user_id, $firstname, $lastname: $k => $v<br>";
  }
}
?>
