<?php
class Logout extends Auth {
	pubic function index() {
		$this->logout();
}
}
?>
