
<form id="uploadFile" action="backend/upload.php" method="post" enctype="multipart/form-data">
 <div class="form-group">
 <label for="fileUpload">Browse File</label>
   <input type="file" name="fileUpload" class="form-control" id="files" aria-describedby="fileTypes" accept=".jpeg, .png, .jpg, .gif, .pdf, .xlsx, .csv, .doc, .docx" >
   <small id="fileTypes" class="form-text text-muted" >Only upload files of the type jpg, png, jpeg, gif, doc, xlsx, csv, and pdf.</small>
 </div>

 <button type="submit" name="submit" class="btn btn-primary">Upload</button>
</form>
