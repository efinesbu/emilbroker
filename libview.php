<?php require "lib.php";
//___________________________________________________________
function get_user_attributes($user_id){
  $user = select_user_attr($user_id);
  $user_array = array();
  if ($user != NULL) {
    foreach($user as $row){
      $user_array[$row['attribute_name']] = $row['attribute_value'];
    }
  }
  return $user_array;
}
//___________________________________________________________
function get_user_seq($user_id, $firstname, $lastname, $event_seq=-1, $verify=TRUE)
{
  $user = get_user_attributes($user_id);
  $last_name = "Customer";
  if (array_key_exists('LastName', $user)) {
    $last_name = $user['LastName'];
  }
  if (array_key_exists('FirstName', $user)) {
    $first_name = $user['FirstName'];
  }
  $rows = NULL;
  if ( !$verify or ($firstname == $first_name and $last_name ==$lastname))
  {
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
function show_review_page($user_id, $firstname, $lastname, $main_row){

}

//___________________________________________________________
function show_user_seq($user_id, $firstname, $lastname, $main_row){
  extract($main_row);
  if ($event_type == 1) {
    print "
    <div class='container'>
    <p>Dear $firstname $lastname!
    <p>On $reg_date we received your request to assist you on<br>
    <center><cite>Subject: ' . . . $subject . . . '</cite></center>
    <p>Our experts are analyzing how we can meet your order.
    We are appologize, but at this time they have not provided any response yet.
    <p>The update of your orde will posted <a href='contact.php?user_id=$user_id'>here</a>
    <p>Please, visit us later.
    <p>Truly yours, FineAssociates.
    </div>
    ";
  } else {
    foreach($main_row as $k => $v) {
        echo "show_last_seq $user_id, $firstname, $lastname: $k => $v<br>";
    }
  }
}
//___________________________________________________________
function show_user_request_to_review($user_id, $firstname, $lastname, $main_row, $reviewer_id){
  extract($main_row);
  if ($event_type == 1) {
    print "
    <div class='container'>
    <p>Dear $reviewer_id!
    <p>On $reg_date we received $firstname $lastname's request to assist on<br>
    <center><cite>Subject: ' . . . $subject . . . '</cite></center>
    <p>The customer wants us:<br>
    <center><cite>'$mgs'</cite></center>
    <p>Please evaluate this request and  provide your prompt response
    <p>Truly yours, FineAssociates.
    </div>
    ";
  } else {
    foreach($main_row as $k => $v) {
        echo "show_last_seq $user_id, $firstname, $lastname: $k => $v<br>";
    }
  }
}
?>
