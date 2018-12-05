<?php
//_______________________________________________________________
function log_customer($user_id, $action='contact.php'){
  $msg = <<<EOD
    <p><span class='error'>* required field</span></p>
    <form action='$action', method='post'>

      <label for='user_id'>Registration Number</label><span class='error'>*
      <input id='user_id' name='user_id' readonly value='$user_id' type='text'>"

      <label for='fname'>First Name</label><span class='error'>*
      <input id='fname' name='firstname' placeholder='Your name from your previous $user_id-th request...' type='text' required>

      <label for='lname'>Last Name</label><span class='error'>*
      <input id='lname' name='lastname' placeholder='Your last name from your previous $user_id-th request...' type='text' required>

    <input value='Submit' type='submit'>
    </form>
EOD;
return $msg;
}

//_______________________________________________________________
function initial_request($action  ='contact.php', $readonly=false,
                        $lastname ='Your last name..',
                        $firstname = 'Your name..',
                        $subject ='What are looking for?',
                        $msg = 'How can we help you today?')
{
  if ($readonly) {
    $readonly = 'readonly';
  }
  $msg = <<<EOD
    <p><span class='error'>* required field</span></p>

    <form action='$action', method='post'>

      <label for='fname'>First Name</label>
      <input id='fname' name='firstname' placeholder='$firstname' $readonly type='text'>

      <label for='lname'>Last Name</label>
      <input id='lname' name='lastname' placeholder='$lastname' $readonly type='text'>

      <label for='subject'>Subject</label><span class='error'>*
      <textarea id='subject' name='subject' placeholder='$subject' required style='height:40px' $readonly></textarea>

      <label for='Message'>Message</label><span class='error'>*
      <textarea id='msg' name='msg' placeholder='$msg' required style='height:100px'$readonly></textarea>
EOD;
if ($readonly != 'readony'){
    $msg .= "<input value='Submit' type='submit'>";
  }
  $msg .= "</form>";
return $msg;
}
//_______________________________________________________________
function customer_followup_request($user_id, $adviser_id,
                        $firstname, $lastname,
                        $action  ='contact.php', $readonly=false,
                        $msg = "Provide your comments on the our adviser's review")
{
  if ($readonly) {
    $readonly = 'readonly';
  }
  $event_type = 3; // user followup comment
  $msg = <<<EOD
    <p><span class='error'>* required field</span></p>

    <form action='$action', method='post'>
      <label for='Message'>Comment</label><span class='error'>*
      <textarea id='msg' name='msg' placeholder='$msg' required style='height:100px'$readonly></textarea>
      <input type="hidden" id="user_id" name="user_id" value="$user_id">
      <input type="hidden" id="lastname" name="lastname" value="$lastname">
      <input type="hidden" id="firstname" name="firstname" value="$firstname">
      <input type="hidden" id="adviser_id" name="adviser_id" value="$adviser_id">
      <input type="hidden" id="event_type" name="event_type" value="$event_type">
      <input type="hidden" id="subject" name="subject" value="Customer Followup Comment">
EOD;
if ($readonly != 'readony'){
    $msg .= "<input value='Submit' type='submit'>";
  }
  $msg .= "</form>";
return $msg;
}

//_______________________________________________________________
function show_user_request($user_id, $action='contact.php') {
$msg = <<<EOD
  <p><span class='error'>* required field</span></p>

  <form action='$action', method='post'>

    <label for='fname'>First Name</label>
    <input id='fname' name='firstname' placeholder='Your name..' type='text'>

    <label for='lname'>Last Name</label>
    <input id='lname' name='lastname' placeholder='Your last name..'' type='text'>

    <label for='subject'>Subject</label><span class='error'>*
    <textarea id='subject' name='subject' placeholder='What are looking for?'' required style='height:40px'></textarea>

    <label for='Message'>Message</label><span class='error'>*
    <textarea id='msg' name='msg' placeholder='How can we help you today?' required style='height:100px'></textarea>

  <input value='Submit' type='submit'>
  </form>
EOD;
return $msg;
}


//_______________________________________________________________
function user_request_to_review($user_id, $firstname, $lastname, $main_row, $reviewer)
{
  extract($main_row);
  if (!empty($reviewer)) {extract($reviewer);}
  $msg = '';
  if ($event_type == 1) {
    $msg .= <<<EOD
    <p>Dear $first_name $last_name!
    <p>On $reg_date we received $firstname $lastname's request to assist on<br>
    <center><cite>Subject: ' . . . $subject . . . '</cite></center>
    <p>The customer wants us:<br>
    <center><cite>'$mgs'</cite></center>
    <p>Please evaluate this request and  provide your prompt response in the comment field below.
    <p>Truly yours, FineAssociates.
EOD;
  }
  return $msg;
}

//_______________________________________________________________
function adviser_comment($user_id, $customer, $adviser, $action='contact_admin.php')
{
  extract($customer);
  if (!empty($adviser)) { extract($adviser); }
  $msg = <<<EOD
    <form action='$action', method='post'>
      <label title='Check "junk box" to mark  the customer message as junk'>Junk:</label>
      <input type='checkbox' id='junk' name='junk' value='junk' title='Check "junk box" to mark  the customer message as junk'>
      <br>
      <label for='comment'>Adviser's Comment</label>
      <textarea id='comment' name='comment' placeholder="Type your review of the cusrtomer's request  here."
      style='height:160px' type='text'></textarea>
      <input type="hidden" id="user_id" name="user_id" value="$user_id">
      <input type="hidden" id="adviser_id" name="adviser_id" value="$UUID">
      <input type="hidden" id="event_type" name="event_type" value="$event_type">
    <input value='Submit' type='submit'>
    </form>
EOD;
  return $msg;
}
?>
