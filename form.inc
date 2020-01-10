<div  class="container">
   <div id="login-box">
      <form name = "myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
         <div class="left">
            <div class=".col-md-6">
               <h1>Upload</h1>
               <input type="text" name="firstname" value="<?php echo $nameFirst;?>" placeholder="First name" ><span class="error"><?php echo $nameFirstErr;?></span>
               <input type="text" name="lastname" value="<?php echo $nameLast;?>" placeholder="Last name" ><span class="error"><?php echo $nameLastErr;?></span><br>
               <span class="error"><?php echo $accessErr;?></span><br>
               <input type="radio" name="access" <?php if ($access=="public") echo 'checked = "checked"';?> value="public"><label class="radio">Public</label><br>
               <input type="radio" name="access" <?php if ($access=="private") echo 'checked = "checked"';?>value="private"><label class="radio">Private</label><br><br><br>
               <input type="submit" class="btn btn-success" name="submit" value="Submit"> &nbsp;&nbsp;<input type="submit" class="btn btn-primary" name="reset" value="Reset"><br><br>	
            </div>
         </div>
         <div class="right">
            <div class=".col-md-6">
               <span class="error"><?php echo $fileErr;?></span>
               Select image to upload:
               <input type="file" name="fileToUpload" id="fileToUpload"><br>
               <span class="error"><?php echo $commentErr;?></span>
               <div class="form-group">
                  <label for="comment">Image Description:</label>
                  <textarea name="comment" class="form-control" rows="5"><?php echo $comment;?></textarea>
               </div>
               <div class="form-group">
                  <label for="comment">Tags:</label>
                  <textarea name="tags" class="form-control" rows="5"><?php echo $tags;?></textarea>
               </div>
               <span class="error"><?php echo $checkboxErr;?></span><br>
               <input type="checkbox" name="copyright" <?php if($checkbox == "Answer") echo 'checked = "checked"';?> value="Answer"><label class="checkbox">I retain the copyright to this image and release it for use on this site.</label><br><br><br><br>
            </div>
         </div>
      </form>
   </div>
</div>