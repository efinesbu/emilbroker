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

    <input value='Submit' type='submit'>
    </form>
EOD;
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
?>
