<h2>Search results:</h2>
<div class="post-container">
    <?php 
    
    foreach($posts as $post) { ?>
    <?php echo "<h4>" . $post->title . "</h4><p>" . $post->description . "Published on: $post->date<br>";?> &nbsp; &nbsp;
        <a href='?controller=post&action=read&id=<?php echo $post->id; ?>'>Read the whole story</a> &nbsp; &nbsp;
<?php } ?>
</div>