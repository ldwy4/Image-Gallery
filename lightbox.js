var url = (window.location.href).substring(0, (window.location.href).lastIndexOf("/")) + "/galleryinfo.json"; //json info
var xmlhttp = new XMLHttpRequest();
var page = location.href.split('/').pop(); //current php page

 

//Makes XML request and begins displaying specific images
function showPrivate(){
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        privateImages(myArr);
    }//if
	};
	xmlhttp.open("POST", url, true);
	xmlhttp.send();
}//showPrivate

//decides on what images to show
function privateImages(arr){
	var i; //element of uploads
	var image; //image object
	
    for(i = 0; i < arr.length; i++) {
	if(arr[i].approved == true){
		
		//shows all approved images
		image = "a" + arr[i].UID;
		document.getElementById("d" + arr[i].UID).className = "editor-grid";
		document.getElementById(image).setAttribute("data-fancybox", "gallery");
		
		//show private images
		if(document.getElementById("access").checked == true){
			if(arr[i].access == "public"){
				image = "a" + arr[i].UID;
				document.getElementById("d" + arr[i].UID).className = "hidden";
				document.getElementById(image).removeAttribute("data-fancybox")
			}//if
			
		//show public images
		}else if(document.getElementById("access2").checked == true){
			if(arr[i].access == "private"){
				image = "a" + arr[i].UID;
				document.getElementById("d" + arr[i].UID).className = "hidden";
				document.getElementById(image).removeAttribute("data-fancybox")
			}//if
			
		}
		
		}//if
	}//for
}//privateImages

//searches for images based on key words
function searching(){
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        searchBar(myArr);
    }//if
	};
	xmlhttp.open("POST", url, true);
	xmlhttp.send();
}//searching

//displays certain images based on what is inputed into the search bar
function searchBar(arr){
	var tagSearch = document.forms["searchbar"]["search"].value; //search input
	
	var i; //counter 
	for(i = 0; i < arr.length; i++) {
	
		//searches only approved images
		if(arr[i].approved == true){
			
			//searches only public images on the public gallery
			if(arr[i].access == "public" && (page == "index.php" || page == "")){
				
				//displays image if input is in the tags associated with the image
				if(arr[i].tags.toLowerCase().includes(tagSearch.toLowerCase())){
					image = "i" + arr[i].UID;
					document.getElementById(image).className = "thumb";
					document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
				}else{
					image = "i" + arr[i].UID;
					document.getElementById(image).className = "hidden";
					document.getElementById("a" + arr[i].UID).removeAttribute("data-fancybox");
				}//else
				
				//displays all public images if nothing is in the search bar
				if(tagSearch == ""){
					image = "i" + arr[i].UID;
					document.getElementById(image).className = "thumb";
					document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
				}//if
			
			//searches public or private images on moderator view
			} else if(page == "moderator.php"){
					
				//searches only private images if private box is checked
				if(document.getElementById("access").checked == true){
					if(arr[i].access == "public"){
						image = "a" + arr[i].UID;
						document.getElementById("d" + arr[i].UID).className = "hidden";
						document.getElementById(image).removeAttribute("data-fancybox")
					}else{
						
						//displays image if input is in the tags associated with the image
						if(arr[i].tags.toLowerCase().includes(tagSearch.toLowerCase())){
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "editor-grid";
							document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
						}else{
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "hidden";
							document.getElementById("a" + arr[i].UID).removeAttribute("data-fancybox");
						}//else
						
						//displays all public images if nothing is in the search bar
						if(tagSearch == ""){
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "editor-grid";
							document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
						}//if
					}//else
				
				//searches for public and private images if private box is not checked
				}else if(document.getElementById("access2").checked == true){
					
					if(arr[i].access == "private"){
						image = "a" + arr[i].UID;
						document.getElementById("d" + arr[i].UID).className = "hidden";
						document.getElementById(image).removeAttribute("data-fancybox")
					}else{
						
						//displays image if input is in the tags associated with the image
						if(arr[i].tags.toLowerCase().includes(tagSearch.toLowerCase())){
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "editor-grid";
							document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
						}else{
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "hidden";
							document.getElementById("a" + arr[i].UID).removeAttribute("data-fancybox");
						}//else
						
						//displays all public images if nothing is in the search bar
						if(tagSearch == ""){
							image = "d" + arr[i].UID;
							document.getElementById(image).className = "editor-grid";
							document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
						}//if
					}//else
					
					
				} else if(document.getElementById("access3").checked == true || document.getElementById("access").checked == false && document.getElementById("access2").checked == false && document.getElementById("access3").checked == false) {
					
					//displays image if input is in the tags associated with the image
					if(arr[i].tags.toLowerCase().includes(tagSearch.toLowerCase())){
						image = "d" + arr[i].UID;
						document.getElementById(image).className = "editor-grid";
						document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
					}else{
						image = "d" + arr[i].UID;
						document.getElementById(image).className = "hidden";
						document.getElementById("a" + arr[i].UID).removeAttribute("data-fancybox");
					}//else
						
					//displays all public images if nothing is in the search bar
					if(tagSearch == ""){
						image = "d" + arr[i].UID;
						document.getElementById(image).className = "editor-grid";
						document.getElementById("a" + arr[i].UID).setAttribute("data-fancybox", "gallery");
					}//if	
					
				}//else if
			}//else if
		}//if
	}//for
}//searchBar