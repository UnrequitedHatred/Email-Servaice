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
