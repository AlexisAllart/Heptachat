<?php
session_start();
if (isset($_SESSION['id']))
{
	header('Location: chat.php');
}
else
{
	header('Location: login.php');
}
?>