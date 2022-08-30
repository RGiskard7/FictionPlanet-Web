<div class="form-group text-center">
    <label class="checkbox-custom-1-label" for="postCheckbox"><h5>Publicación visible</h5></label>&nbsp;&nbsp;&nbsp;
    <input class="checkbox-custom-1" type="checkbox" id="postCheckbox" name="postCheckbox" <?= ($post->is_visible() == 1) ? 'value="1" checked' : 'value="0"'; ?>>
</div>
<div class="form-group">
    <input maxlength="150" class="form-control" name="postTitle" placeholder="Título" type="text" value="<?= $post->get_title(); ?>" required>
</div>
<div class="form-group">
    <textarea maxlength="370" class="form-control" id="postIntroduction" name="postIntroduction" 
              placeholder="Pequeña introducción" required><?= $post->get_introduction(); ?></textarea>
</div>
<div class="form-group">
    <textarea name="postContent" id="postContent" rows="10" cols="80" required><?= html_entity_decode($post->get_content(), ENT_QUOTES, "UTF-8"); ?></textarea>
</div>