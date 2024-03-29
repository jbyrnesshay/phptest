<?php
$errors = [];
$missing = [];
if (isset($_POST['send'])) {
  $expected = ['name', 'email', 'comments'];
  $required = ['name', 'comments'];
  $to = 'David Powers <david@example.com>';
  $subject = 'Feedback from online form';
  $headers = [];
  $headers[] = 'From: webmaster@example.com';
  $headers[] ='Cc: another@example.com';
  $headers[] ='Content-type: text/plain; charset=utf-8';
  $authorized = null;
  require './includes/process_mail.php';
  if ($mailsent) {
    header('location:thanks.php');
    exit;
  }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Conditional error messages</title>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<h1>Contact Us</h1>
<?php if ($_POST && ($suspect || isset($errors['mailfail']))): ?>
  <p class="warning">Sorry your email couldn't' be sent </p>
<?php elseif ($errors || $missing) : ?>
  <p class="warning"> please fix the items indicated </p>
<?php endif; ?>
<form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
  <p>
    <label for="name">Name:
    <?php if ($missing && in_array('name', $missing)) : ?>
      <span class="warning">please enter your name </span>
    <?php endif; ?>
    </label>
    <input type="text" name="name" id="name"
    <?php 
      if ($errors || $missing) {
        echo 'value="'.htmlentities($name).'"';
      } ?>
      >
  </p>
  <p>
    <label for="email">Email:
    <?php if ($missing && in_array('email', $missing)) : ?>
      <span class="warning">please enter your email addresss </span>
    <?php elseif(isset($errors['email'])) : ?>
        <span class="warning">invalid email address</span>
    <?php endif; ?>
    </label>
    <input type="email" name="email" id="email"  <?php 
      if ($errors || $missing) {
        echo 'value="'.htmlentities($email).'"';
      } ?>
      >
  </p>
  <p>
    <label for="comments">Comments:
  <?php if ($missing && in_array('comments', $missing)) : ?>
      <span class="warning">you forgot to add any comments</span>
    <?php endif; ?>
    </label>
    <textarea name="comments" id="comments"><?php 
        if($errors || $missing) {
          echo htmlentities($comments);
        }

    ?></textarea>
  </p>
  <p>
    <input type="submit" name="send" id="send" value="Send Comments">
  </p>
</form>
 
</body>
</html>