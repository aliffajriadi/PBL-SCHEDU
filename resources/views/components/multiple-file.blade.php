<style>
    body {
  padding: 0;
  margin: 0;
  font-family: Roboto;
  font-weight: normal;
  background: url("images/4101062.jpg") top center;
  background-size: cover;
  background-repeat: no-repeat;
  width: 100%;
  height: 100vh;
}

h2 {
  font-size: 24px;
  margin-top: 25px;
  margin-bottom: 20px;
  font-weight: 300;
  letter-spacing: 2px;
}

.upload-file {
  float: left;
  width: 100%;
}
.upload-file .upload-wrapper {
  float: left;
  width: 100%;
}
.upload-file .upload-wrapper label {
  float: left;
  width: 100%;
  border-radius: 10px;
  padding: 250px 40px 5px 40px;
  text-align: center;
  background: url(images/2813838.jpg) top center no-repeat #fff;
  background-size: 300px;
  position: relative;
  box-shadow: 10px 10px 0px #ffbe32, -10px -10px 0px #32adff;
}
.upload-file .upload-wrapper label > input[type=file] {
  display: none;
}
.upload-file .upload-wrapper label p {
  font-size: 20px;
  font-weight: 300;
  margin-top: 50px;
}
.upload-file .upload-wrapper label p a {
  font-weight: 700;
  color: #007bff;
}

#image-gallery {
  float: left;
  width: 100%;
  margin-top: 20px;
}
#image-gallery .thumb-Images {
  float: left;
  width: 100%;
}
#image-gallery .thumb-Images li {
  float: left;
  width: 100%;
  background: #fff;
  border-radius: 10px;
  display: flex;
  padding: 10px 10px;
  margin-bottom: 30px;
  position: relative;
  box-shadow: -10px -10px 0px #ffbe32, 10px 10px 10px rgba(0/, 0, 0, 0.1);
}
#image-gallery .thumb-Images li .file-info {
  display: inline-block;
  font-size: 15px;
  font-weight: 400;
  width: 70%;
  text-overflow: ellipsis;
  white-space: nowrap;
  line-height: 30px;
}
#image-gallery .thumb-Images li .img-wrap {
  margin-right: 10px;
}
#image-gallery .thumb-Images li .img-wrap img.thumb {
  height: 30px;
  width: 30px;
  border-radius: 30px;
  margin-left: 5px;
  cursor: pointer;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
}
#image-gallery .thumb-Images li .img-wrap .close {
  position: absolute;
  right: 12px;
  color: red;
}
#image-gallery .thumb-Images li .img-wrap .close i {
  font-size: 20px;
}

/*# sourceMappingURL=style.css.map */

</style>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="upload-file">
                <div class="row">
                    <div class="col-6">
                        <h2>Upload Files</h2>
                    </div>

                </div>
                <div class="upload-wrapper">
                    <label>
                        <input type="file" name="files[]" id="files" multiple accept="image/jpeg, image/png, image/gif,">
                        <p>Drop your files here. <br>or <a>Browse</a></p>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-0">Uploaded Files</h2>
                </div>
            </div>
            <output id="image-gallery"></output>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="script.js"></script>
<script type="257be86a981729866f2fa61c-text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83834093-1', 'auto');
    ga('send', 'pageview');

  </script>

  <script>
    //I added event handler for the file upload control to access the files properties.
document.addEventListener("DOMContentLoaded", init, false);

//To save an array of attachments
var AttachmentArray = [];

//counter for attachment array
var arrCounter = 0;

//to make sure the error message for number of files will be shown only one time.
var filesCounterAlertStatus = false;

//un ordered list to keep attachments thumbnails
var ul = document.createElement("ul");
ul.className = "thumb-Images";
ul.id = "imgList";

function init() {
	//add javascript handlers for the file upload event
	document
		.querySelector("#files")
		.addEventListener("change", handleFileSelect, false);
}

//the handler for file upload event
function handleFileSelect(e) {
	//to make sure the user select file/files
	if (!e.target.files) return;

	//To obtaine a File reference
	var files = e.target.files;

	// Loop through the FileList and then to render image files as thumbnails.
	for (var i = 0, f; (f = files[i]); i++) {
		//instantiate a FileReader object to read its contents into memory
		var fileReader = new FileReader();

		// Closure to capture the file information and apply validation.
		fileReader.onload = (function(readerEvt) {
			return function(e) {
				//Apply the validation rules for attachments upload
				ApplyFileValidationRules(readerEvt);

				//Render attachments thumbnails.
				RenderThumbnail(e, readerEvt);

				//Fill the array of attachment
				FillAttachmentArray(e, readerEvt);
			};
		})(f);

		// Read in the image file as a data URL.
		// readAsDataURL: The result property will contain the file/blob's data encoded as a data URL.
		// More info about Data URI scheme https://en.wikipedia.org/wiki/Data_URI_scheme
		fileReader.readAsDataURL(f);
	}
	document
		.getElementById("files")
		.addEventListener("change", handleFileSelect, false);
}

//To remove attachment once user click on x button
jQuery(function($) {
	$("div").on("click", ".img-wrap .close", function() {
		var id = $(this)
			.closest(".img-wrap")
			.find("img")
			.data("id");

		//to remove the deleted item from array
		var elementPos = AttachmentArray.map(function(x) {
			return x.FileName;
		}).indexOf(id);
		if (elementPos !== -1) {
			AttachmentArray.splice(elementPos, 1);
		}

		//to remove image tag
		$(this)
			.parent()
			.find("img")
			.not()
			.remove();

		//to remove div tag that contain the image
		$(this)
			.parent()
			.find("div")
			.not()
			.remove();

		//to remove div tag that contain caption name
		$(this)
			.parent()
			.parent()
			.find("div")
			.not()
			.remove();

		//to remove li tag
		var lis = document.querySelectorAll("#imgList li");
		for (var i = 0; (li = lis[i]); i++) {
			if (li.innerHTML == "") {
				li.parentNode.removeChild(li);
			}
		}
	});
});

//Apply the validation rules for attachments upload
function ApplyFileValidationRules(readerEvt) {
	//To check file type according to upload conditions
	if (CheckFileType(readerEvt.type) == false) {
		alert(
			"The file (" +
			readerEvt.name +
			") does not match the upload conditions, You can only upload jpg/png/gif files"
		);
		e.preventDefault();
		return;
	}

	//To check file Size according to upload conditions
	if (CheckFileSize(readerEvt.size) == false) {
		alert(
			"The file (" +
			readerEvt.name +
			") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
		);
		e.preventDefault();
		return;
	}

	//To check files count according to upload conditions
	if (CheckFilesCount(AttachmentArray) == false) {
		if (!filesCounterAlertStatus) {
			filesCounterAlertStatus = true;
			alert(
				"You have added more than 10 files. According to upload conditions you can upload 10 files maximum"
			);
		}
		e.preventDefault();
		return;
	}
}

//To check file type according to upload conditions
function CheckFileType(fileType) {
	if (fileType == "image/jpeg") {
		return true;
	} else if (fileType == "image/png") {
		return true;
	} else if (fileType == "image/gif") {
		return true;
	} else {
		return false;
	}
	return true;
}

//To check file Size according to upload conditions
function CheckFileSize(fileSize) {
	if (fileSize < 300000) {
		return true;
	} else {
		return false;
	}
	return true;
}

//To check files count according to upload conditions
function CheckFilesCount(AttachmentArray) {
	//Since AttachmentArray.length return the next available index in the array,
	//I have used the loop to get the real length
	var len = 0;
	for (var i = 0; i < AttachmentArray.length; i++) {
		if (AttachmentArray[i] !== undefined) {
			len++;
		}
	}
	//To check the length does not exceed 10 files maximum
	if (len > 9) {
		return false;
	} else {
		return true;
	}
}

//Render attachments thumbnails.
function RenderThumbnail(e, readerEvt) {
	var li = document.createElement("li");
	ul.appendChild(li);
	li.innerHTML = [
		'<div class="img-wrap img-wrapper">' +
		'<a href="',e.target.result,'"><img class="thumb" src="',
		e.target.result,
		'" title="',
		escape(readerEvt.name),
		'" data-id="',
		readerEvt.name,
		'"/></a>' + "<span class=\"close\"><i class=\"fa fa-trash-o\"></i></span></div>"
	].join("");

	var div = document.createElement("div");
	div.className = "file-info";
	li.appendChild(div);
	div.innerHTML = [readerEvt.name].join("");
	document.getElementById("image-gallery").insertBefore(ul, null);
}

//Fill the array of attachment
function FillAttachmentArray(e, readerEvt) {
	AttachmentArray[arrCounter] = {
		AttachmentType: 1,
		ObjectType: 1,
		FileName: readerEvt.name,
		FileDescription: "Attachment",
		NoteText: "",
		MimeType: readerEvt.type,
		Content: e.target.result.split("base64,")[1],
		FileSizeInBytes: readerEvt.size
	};
	arrCounter = arrCounter + 1;
}



  </script>