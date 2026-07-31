<div class="p-3 border-bottom d-flex align-items-center">
    <img src="<?= !empty($receiverAvatar) ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $receiverAvatar : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle mr-2" width="32" height="32" alt="" style="object-fit:cover;">
    <span class="font-weight-bold flex-grow-1"><?php echo h($receiverUserName); ?></span>
    <button id="btnBackUserChatList" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i></button>
</div>

<div id="<?php echo 'chatHistoryWindow_' . $receiverUserId; ?>" class="chatHistoryWindow" data-touserid="<?php echo $receiverUserId; ?>">
    <ul class="list-unstyled mb-0">
        <?php if (isset($conversation) && !empty($conversation)): ?>
            <?php foreach($conversation as $message): ?>
                <li class="<?= $message->getSenderUserId() == $senderUserId ? 'sent' : 'replies' ?>">
                    <p><?= nl2br(h($message->getMessage())); ?><br>
                    <span class="time"><?= date('H:i', strtotime($message->getTimestamp())); ?></span></p>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="text-center text-muted py-4">Chat vacio</li>
        <?php endif; ?>
    </ul>
</div>

<div class="p-2 border-top">
    <div class="input-group">
        <textarea id="<?php echo 'chatMessage_' . $receiverUserId; ?>" class="form-control chatMessage" data-touserid="<?php echo $receiverUserId; ?>" placeholder="Escribe un mensaje..." rows="1" style="resize:none;border-radius:20px;"></textarea>
        <div class="input-group-append ml-1">
            <button id="<?php echo 'sendChatButton_' . $receiverUserId; ?>" type="button" class="btn btn-primary rounded-circle sendChatButton" data-touserid="<?php echo $receiverUserId; ?>" style="width:36px;height:36px;padding:0;">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
