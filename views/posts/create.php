<p>Fill in the following form to create a new product:</p>
<form action="" method="POST" class="w3-container" enctype="multipart/form-data">

    <h2>Add New Post</h2>
        <p>
            <input class="w3-input" type="text" name="title" required autofocus>
            <label>Title</label>
        </p>
        <p>
            <input class="w3-input" type="text" name="content" required>
            <label>Content</label>
        </p>
        <p>
            <input class="w3-input" type="text" name="description" required>
            <label>Description</label>
        </p>

        <input type="hidden" 
               name="MAX_FILE_SIZE" 
               value="10000000"
               />

        <input type="file" name="myUploader" required />
        <p>
            <input type="submit" value="Add Post">
        </p>
</form>