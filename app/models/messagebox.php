<?php
/**
 * MessageBox - a class for handling status-messages
 *
 * GPL
 */

class MessageBox {
	private $messages;

	function __construct() {
		$this->messages = array();
	}

	public function getMessages() {
		return $this->messages;
	}

	public function addMessage($type, $message) {
		$this->messages[] = array($type => $message);
	}

	public function &getInstance() {
		static $message_box;

		if ($message_box) {
			$message_box = new MessageBox();
		}

		return $message_box;
	}

	static function error($message) {
		$message_box = MessageBox::getInstance();
		$message_box->addMessage('error', $message);
	}

	static function success($message) {
		$message_box = MessageBox::getInstance();
		$message_box->addMessage('success', $message);

		return $message_box;
	}
}
