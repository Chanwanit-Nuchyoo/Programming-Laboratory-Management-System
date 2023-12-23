function checkSourceCode(){
    //alert("checking source code");

    var sourceCode = document.getElementById("userfile");
    var sourceCodeName = sourceCode.value;
    
    if(sourceCodeName==""){
        alert("คุณยังไม่ได้เลือกซอร์สโค้ดที่ต้องการส่ง");
        return false;
    }
    var extension = sourceCodeName.split(".");
    if(extension[1]!=document.getElementById("id_extension").value) {
        alert("อนุญาตให้ส่งไฟล์สกุล ."+document.getElementById("id_extension").value+"เท่านั้น");
        return false;
    }
    /*
    var fileName = extension[0].split('\\');
    if(/^[a-zA-Z0-9]+/.test(fileName[2]) == true) {
        
    } else {
        alert("ชื่อไฟล์สามารถประกอบด้วย a-z,A-Z,0-9 เท่านั้น");
        return false;
    }
    
    var soruceCodeFileSize = parseInt(sourceCode.files[0].size);
    if (sourceCodeFileSize > 4096) {
        alert("File size is too big : "+sourceCodeFileSize+" bytes.");
        return false;
    }
    */
    alert("File name : "+sourceCodeName+" "+soruceCodeFileSize);
}

function validate_fileupload(filename)	{		
    var allowed_extensions = new Array("jpg","png","gif","c","py");
    // split function will split the filename by dot(.), 
    // and pop function will pop the last element from the array which will give you the extension as well. 
    // If there will be no extension then it will return the filename.
    var file_extension = fileName.split('.').pop().toLowerCase(); 
    for(var i = 0; i <= allowed_extensions.length; i++)		{
        if(allowed_extensions[i]==file_extension)			{
            return true; // valid file extension
        }
    }		
    
    alert(file_extension + " is NOT valid filename extension !!!");
    return FALSE;		
}

function form_submit(obj) {             // obj is button object located inside form
    const form_to_submit = obj.form;
    obj.disabled = true;                // prevent multiple submit
    //console.log(form_to_submit);
    //checkSourceCode();
    
    let file_content = get_file_content();
    console.log(`File content ==> ${file_content}`);
    // // let header_content = get_header_content(file_content);
    // // console.log(`Header ==> ${header_content}`);
    // if (file_content.indexOf("append") >= 0 ) {
    // 	alert('"apeend" is not allowed !!!');
    // 	return false;
    // } else if (file_content.indexOf("insert") >= 0 ) {
    // 	alert('"insert" is not allowed !!!');
    // 	return false;
    // }


    form_to_submit.submit();
}

function get_file_content() {    
    const input_file = document.querySelector('input[type="file"]');
    var fr1 = new FileReader();
    fr1.onload = function(event) {
        var text = fr1.result;
        return text;
        };    
}

function get_header_content(strip_comment) {
    header_content = strip_comment;
    return header_content;
}