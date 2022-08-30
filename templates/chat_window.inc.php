<div class="p-2">
    <div id="chatHistoryWindowHeader" class="mb-3 mt-3">
        <div class="row">
            <div class="col-10">
                <h5><img src="<?php echo IMAGES_URL . "f2.png"; ?>" class="avatar img-circle img-thumbnail" alt="avatar" style="border:0; vertical-align: left;">
                <?php echo $recieverUserName; ?></h5>
            </div>
            <div class="col-2">
                <button id="btnBackUserChatList" class="btn btn-outline-secondary pull-right gmd-1">
                <i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>

    <div id="<?php echo 'chatHistoryWindow_' . $receiverUserId; ?>" class="chatHistoryWindow" data-touserid="<?php echo $receiverUserId; ?>">
        <ul class="list-unstyled">
            <?php if (isset($conversation) && !empty($conversation)): ?>
                <?php foreach($conversation as $message): ?>
                    <?php if ($message->getSenderUserId() == $senderUserId): ?>
                        <li class="sent">
                    <?php else: ?>
                        <li class="replies">
                    <?php endif; ?>
                        <p>
                            <?php echo str_replace(chr(10),"<br>",$message->getMessage()); ?>
                            <br>
                            <font size = 1><small><em><?php echo $message->getTimestamp(); ?></em></small></font>
                        </p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Chat vaío</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="form-group">
        <textarea name="<?php echo 'chatMessage_' . $receiverUserId; ?>" id="<?php echo 'chatMessage_' . $receiverUserId; ?>" 
                    class="form-control chatMessage" data-touserid="<?php echo $receiverUserId; ?>" placeholder="Escribe un mensaje..."></textarea>
    </div>

    <div class="form-group" align="right">
        <button id="<?php echo 'sendChatButton_' . $receiverUserId; ?>" type="button" name="sendChatButton" class="btn btn-info sendChatButton gmd-1" 
                data-touserid="<?php echo $receiverUserId; ?>">Enviar</button>
    </div>
</div>

