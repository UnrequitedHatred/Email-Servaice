function register($username, $email, $password) {
 $conn = db_connect();
 $result = $conn->query("select * from user where username='".$username."'");
 if (!$result) {
 throw new Exception('Could not execute query');
 }
 if ($result->num_rows>0) {
 throw new Exception('That username is taken - go back and choose another one.');
 }

 $result = $conn->query("insert into user values
('".$username."', sha1('".$password."'), '".$email."')");
 if (!$result) {
 throw new Exception('Could not register you in database - please try again
later.');
 }
 return true;
}
function check_valid_user() {

 if (isset($_SESSION['valid_user'])) {
echo "Logged in as ".$_SESSION['valid_user'].".<br>";
 } else {
 
 do_html_heading('Problem:');
 echo 'You are not logged in.<br>';
 do_html_url('login.php', 'Login');
 do_html_footer();
 exit;
 }
}
function change_password($username, $old_password, $new_password) {
 login($username, $old_password);
 $conn = db_connect();
 $result = $conn->query("update user
set passwd = sha1('".$new_password."')
where username = '".$username."'");
 if (!$result) {
 throw new Exception('Password could not be changed.');
 } else {
 return true; // changed successfully
 }
}
function reset_password($username) {
 $new_password = get_random_word(6, 13);
 if($new_password == false) {
 $new_password = "changeMe!";
 }
 $rand_number = rand(0, 999);
 $new_password .= $rand_number;
 $conn = db_connect();
 $result = $conn->query("update user
set passwd = sha1('".$new_password."')
where username = '".$username."'");
 if (!$result) {
 throw new Exception('Could not change password.');
 } else {
 return $new_password; 
 }
}
