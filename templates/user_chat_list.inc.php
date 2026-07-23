<div class="table-responsive p-2" style="height: auto; overflow: auto;">
    <table id="usersChatTable" class="table table-hover table-striped" style="height: auto; overflow: auto; white-space: nowrap;">
        <thead>
            <tr>
                <th>Contactos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($usersChatList) && !empty($usersChatList)): ?>
                <?php foreach($usersChatList as $user): ?>
                    <?php
                    Connection::open_connection();
                    $unreadMessage = ChatMessageDAO::get_unread_message_count(Connection::get_connection(), $user->get_id(), $_SESSION["idUser"]);
                    Connection::close_connection();
                    ?>
                    <tr>
                        <td class="contact" data-touserid="<?php echo $user->get_id(); ?>">
                            <img src="<?php echo IMAGES_URL . "f2.png"; ?>" class="avatar img-circle img-thumbnail" alt="avatar" style="border:0;">
                            <?php echo h($user->get_user_name());?>
                            <strong><span id="<?php echo 'unread_' . $user->get_id(); ?>" class="unread gmd-2"><?php echo $unreadMessage; ?></span></strong>
                        </td>
                        <td class="text-right">
                            <button id="startChatButton" type="button" class="btn btn-info btn-sm startChatButton gmd-1" 
                                    data-touserid="<?php echo $user->get_id(); ?>" data-tousername="<?php echo h($user->get_user_name()); ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr><td colspan="2">No hay contactos</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script type="text/javascript">
        $('#usersChatTable').DataTable({
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Buscar contacto..."
            },
            "bInfo": false,
            "paging": false, 
            "lengthChange":false,
            "columns": [
                {"data": 0},
                {"data": 1, 'orderable': false, 'searchable': false}
            ],
            "scroll": true,
            "responsive": true
        });
    </script>
</div>