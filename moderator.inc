<div class="container-fluid">
   <form name = "downloading" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
      <div class="row">
         <span class=".col-md-4">
         <input type="submit" class="bodybuttons" name="download" value="Download All">
         </span>
         <span class=".col-md-4">
         <input type="submit" class="bodybuttons" name="delete" value="Delete">
         </span>
         <span class=".col-md-4">
         <input type="submit" class="bodybuttons" name="complete" value="Save Edits">
         </span>
   
	   <span id="displaybtns">Display:</span>
	   <div class="pretty p-default p-round p-smooth">
	   <input name="display" <?php if ($display=="access") echo 'checked = "checked"';?>
	   value="access" type="radio" id="access" onclick="showPrivate()" />
	   <div class="state p-primary">
	   <label>Private</label>
	   </div>
	   </div>
	   <div class="pretty p-default p-round p-smooth">
	   <input name="display" <?php if ($display=="access2") echo 'checked = "checked"';?>
	   value="access2" type="radio" id="access2" onclick="showPrivate()" />
	   <div class="state p-primary">
	   <label>Public</label>
	   </div>
	   </div>	
	   <div class="pretty p-default p-round p-smooth">
	   <input name="display" <?php if ($display=="access3") echo 'checked = "checked"';?>
	   value="access3" type="radio" id="access3" onclick="showPrivate()" />
	   <div class="state p-primary">
	   <label>All</label>
	   </div>
	   </div>
	   </div>
</div>