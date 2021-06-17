<?php
if ( isset($_POST['secret']) && $_POST['secret'] == '42' ) {
    setCookie('secret', '42', time() + 15 * 3600 * 24);
} else if ( !isset($_COOKIE['secret']) || $_COOKIE['secret'] != '42' ) {
?>
<form method="post">
Enter the unlock code
<input type="text" name="secret">
<input type="submit">
</form>
<?php
    return;
}
?>
<h1>Welcome</h1>
<p>
Here is the 
<a href="md/chap01.md">book in progress</a>.
</p>
<p>
Please feel free to improve this text in
<a href="https://github.com/csev/cc4e/" target="_blank">Github</a>.
</p>
