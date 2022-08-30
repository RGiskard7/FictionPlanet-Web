<div class="form-group text-center">
    <label class="checkbox-custom-1-label" for="postCheckbox"><h5>Publicación visible</h5></label>&nbsp;&nbsp;&nbsp;
    <input class="checkbox-custom-1" type="checkbox" id="postCheckbox" name="postCheckbox" value="1" <?php $validator->show_is_visible(); ?>>
</div>
<div class="form-group">
    <input class="form-control" name="postTitle" placeholder="Título. (148 carácteres max.)" type="text" <?php $validator->show_title(); ?>>
    <?php $validator->show_error_title(); ?>
</div>
<div class="form-group">
    <textarea class="form-control" name="postIntroduction" id="postIntroduction" 
              placeholder="Pequeña introducción. (350 carácteres max.)"><?php $validator->show_introduction(); ?></textarea>
    <?php $validator->show_error_introduction(); ?>
</div>
<div class="form-group">
    <textarea class="form-control" name="postContent" id="postContent" placeholder="Contenido del post"><?php $validator->show_content(); ?></textarea>
    <?php $validator->show_error_content(); ?>
</div>

