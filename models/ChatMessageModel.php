<?php

class ChatMessageModel {

    private $id;
    private $senderUserId;
    private $receiverUserId;
    private $message;
    private $timestamp;
    private $status;

    public function __construct($id, $senderUserId, $receiverUserId, $message, $timestamp, $status) {
        $this->id = $id;
        $this->senderUserId = $senderUserId;
        $this->receiverUserId = $receiverUserId;
        $this->message = $message;
        $this->timestamp = $timestamp;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getSenderUserId() {
        return $this->senderUserId;
    }

    public function getReceiverUserId() {
        return $this->receiverUserId;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}
?>

