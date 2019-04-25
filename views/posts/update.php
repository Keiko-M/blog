<p>Fill in the following form to update an existing blog entry:</p>
<form action="" method="POST" class="w3-container" enctype="multipart/form-data">
    <h2>Update Post</h2>
    <p>
        <input class="w3-input" type="text" name="title" value="<?= $post->title; ?>">
        <label>Title</label>
    </p>
    <p>
        <input class="w3-input" type="text" name="content" value="<?= $post->content; ?>" >
        <label>Content</label>
    </p>
    <p>
        <input class="w3-input" type="text" name="description" value="<?= $post->description; ?>" >
        <label>Description</label>
    </p>
        <!--<button><a href="?controller=post&action=unpublish&id=<?php echo $post->id; ?>">Unpublish</a>-->
    
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    <?php
    $file = 'views/images/' . $post->title . '.jpeg';
    if (file_exists($file)) {
        $img = "<img src='$file' width='150' />";
        echo $img;
    } else {
        echo "<img src='views/images/standard/_noproductimage.png' width='150' />";
    }
    ?>
    <br/>
    <input type="file" name="myUploader" class="w3-btn w3-pink" />
    <p>
        <input class="w3-btn w3-gray" type="submit" value="Update Post">
    </p>
</form>