<div class="p-2">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <span class="input-group-text bg-transparent border-0"><i class="fa fa-search text-muted"></i></span>
        </div>
        <input type="text" id="chatSearchInput" class="form-control border-0" placeholder="Buscar contacto..." style="background:transparent;">
    </div>
    
    <?php if (isset($usersChatList) && !empty($usersChatList)): ?>
        <?php foreach($usersChatList as $user): ?>
        <?php
        Connection::open_connection();
        $unreadMessage = ChatMessageDAO::get_unread_message_count(Connection::get_connection(), $user->get_id(), $_SESSION["idUser"]);
        Connection::close_connection();
        ?>
        <div class="d-flex align-items-center p-2 mb-1 chat-contact contact" data-touserid="<?= $user->get_id(); ?>" 
             style="cursor:pointer;border-radius:8px;transition:background 0.15s;">
            <?php $av = $user->get_avatar(); ?>
            <img src="<?= $av ? UPLOAD_IMG_GALLERY_URL . 'avatars/' . $av : IMAGES_URL . 'avatar_2x.png'; ?>" class="rounded-circle mr-2" width="36" height="36" alt="" style="object-fit:cover;">
            <div class="flex-grow-1 min-width-0">
                <div class="font-weight-bold small"><?= h($user->get_user_name()); ?></div>
            </div>
            <?php if ($unreadMessage): ?>
            <span id="<?= 'unread_' . $user->get_id(); ?>" class="unread"><?= $unreadMessage; ?></span>
            <?php else: ?>
            <span id="<?= 'unread_' . $user->get_id(); ?>"></span>
            <?php endif; ?>
            <button class="btn btn-sm btn-light startChatButton ml-2" data-touserid="<?= $user->get_id(); ?>" data-tousername="<?= h($user->get_user_name()); ?>">
                <i class="fa fa-comment"></i>
            </button>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center text-muted py-4">No hay contactos</div>
    <?php endif; ?>
</div>
