// ----------------- for edit profile ---------------------------
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

//---------------------- Update number of students ---------------------------------
document.addEventListener("DOMContentLoaded", function() {
    //setTimeout(update_online_student,1000);
    //setInterval(update_online_student,60000);
    update_online_student();
    // console.log(new Date())
    if (user_role == "student") {
        setInterval(update_online_student,0.5*60*1000);   // 0.5 minutes
    } else if (user_role == "supervisor") { 
        setInterval(update_online_student,30*1000); // 30 seconds
    } else {
        setInterval(update_online_student,100000);
    }
    
});
// 13 January 2022
function update_online_student () {
    //console.log(`baseurl_ = ${baseurl_}`);
    //console.log(`user_id = ${user_id}`);
    //console.log(`user_role = ${user_role}`);
    // let URL_ = baseurl+"index.php/plms_json/get_online_student/"+user_id+"/"+user_role;
    var URL_ = baseurl+"index.php/plms_json/get_online_student/"+infoForTracking.session.ci_session;
    // console.log("URL_=>"+URL_);

    fetch(URL_, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(infoForTracking)
    })
    .then( (res) => res.json() )
    .then( (data) => {
        // console.log(data);
        let online_students = data.length;
        // update nav_left
        document.querySelector('#online_students').innerText=`Online students : ${online_students}`;
        // update  'student_show' page       
        let pageName = window.location.pathname.split('/').slice(-2)[0];        
        if (pageName==='student_show'){
            let groupID = window.location.pathname.split('/').slice(-1);
            groupID = parseInt(groupID);
            let students_in_group = data.filter(ele=> parseInt(ele.stu_group)===groupID).length;
            // above line doesnot work on firefox
            // let students_in_group =[];
            // for(i=0;i<data.length;i++){
            //     if (data[i].stu_group===groupID) {
            //         students_in_group.append(data[i]);
            //     }
            // }
            // students_in_group = students_in_group.length;
            // console.log(`students_in_group => ${students_in_group}`);
            document.querySelector('#stu_in_group').innerText=students_in_group;
            let stu_rows = document.querySelectorAll('.student_row');
            // console.log(stu_rows)
            stu_rows.forEach((item,index,self)=> {
                let stu_id = item.getAttribute('stu_id');
                // console.log(`${index+1} => ${stu_id}`);
                if (data.find(ele=> parseInt(stu_id)=== parseInt(ele.stu_id))) {
                    item.style.backgroundColor="#e6ffff"; 
                }else {
                    item.style.backgroundColor="#ffe6e6"; 
                }
               
            })

        }
    });
}


//---------------------- for selected file -----------------------------------------
// 13 Sep 2020
// 29 Aug 2022 
//      - check file type
//      - check import
//      - 
function removeComments(str) {
    //console.log("remove");
    //console.log(content);
    //console.log(str);
    str = ('__' + str + '__').split('');
    //console.log("==>"+str);
    // for (var i = 0, l = str.length; i < l; i++) {
    //     console.log(i+"--> "+str[i]+"==>"+str[i].charCodeAt(0));
    // }
    var mode = {
        singleQuote: false,
        doubleQuote: false,
        regex: false,
        blockComment: false,
        lineComment: false,
        condComp: false 
    };
    
    for (var i = 0, l = str.length; i < l; i++) {
    
        if (mode.regex) {
            if (str[i] === '/' && str[i-1] !== `\\`) {
                mode.regex = false;
            }
            continue;
        }
    
        if (mode.singleQuote) {
            if (str[i] === "'" && str[i-1] !== '\\') {
                mode.singleQuote = false;
            }
            continue;
        }
    
        if (mode.doubleQuote) {
            if (str[i] === '"' && str[i-1] !== '\\') {
                mode.doubleQuote = false;
            }
            continue;
        }
    
        if (mode.blockComment) {
            if (str[i] === '*' && str[i+1] === '/') {
                str[i+1] = '';
                mode.blockComment = false;
            }
            str[i] = '';
            continue;
        }
    
        if (mode.lineComment) {
            //if (str[i+1] === 'n' || str[i+1] === 'r') {
            if (str[i+1].charCodeAt(0) == 10) {
                
                mode.lineComment = false;
                str[i] ='';
                i=i+1;
                continue;
            }
            str[i] = '';
            continue;
        }
    
        if (mode.condComp) {
            if (str[i-2] === '@' && str[i-1] === '*' && str[i] === '/') {
                mode.condComp = false;
            }
            continue;
        }
    
        mode.doubleQuote = str[i] === '"';
        mode.singleQuote = str[i] === "'";
    
        if (str[i] === '/') {
    
            if (str[i+1] === '*' && str[i+2] === '@') {
                mode.condComp = true;
                continue;
            }
            if (str[i+1] === '*') {
                str[i] = '';
                mode.blockComment = true;
                continue;
            }
            if (str[i+1] === '/') {
                str[i] = '';
                str[i+1] = '';
                i = i+1;
                mode.lineComment = true;
                continue;
            }
            mode.regex = true;
    
        }
    
    }
    
    return str.join('').slice(2, -2);
    
}

function removePythonComment(fileContent) {
    let contents = fileContent.split('\n');
    // remove comment startwith #
    content_no_comment ="";
    contents.forEach( (item,index,self) => {
        // console.log(`${index+1} => ${item}`);
        if ( (item.trim()).startsWith('#')) {
            // console.log("-----------------");
        } else {
            content_no_comment += (item+'\n'); 
        }
    });
    return content_no_comment;
}

function checkSourceCode() {
    console.log("checkSourceCode is working ....")
    const submitButton = document.querySelector('button[name="submit_button"]');
    // submitButton.disabled=true ;
    const input = document.querySelector('input[type="file"]');
    console.log(input.files)
    console.log(input.files.length)
    if (input.files.length !=1 ) {
        console("Multiple files NOT allow !!!",input.files.length)
        return false;
    }
    console.log(input.value)
    const file = /([^\\]+)$/.exec(input.value)[1];   // userfile.replace(/^.*(\\|\/|\:)/, '');
    console.log(`file=> ${file}`);
    const fileName = (file.split('.')).at(0);
    console.log(`fileName=> ${fileName}`);
    const fileExtension = (file.split('.')).at(-1);
    console.log(`fileExtension=> ${fileExtension}`);
    if (fileExtension != 'py') {
        console.log("อนุญาตให้ส่งไฟล์สกุล .py เท่านั้น");
        alert("อนุญาตให้ส่งไฟล์สกุล .py เท่านั้น");
        return false;
    }
    console.log("Checking file content . . . ")
    const reader = new FileReader()
    reader.readAsText(input.files[0], "UTF-8");
    reader.onload = function(evt) {
        const fileContent = evt.target.result;
        // console.log(`characters => ${fileContent.length}`,"\n",fileContent);
        let total_lines = fileContent.split('\n');
        // console.log("total_lines",total_lines);
        // console.log(`Total lines => ${total_lines.length}`);
        let no_comment = removePythonComment(fileContent);
        // console.log(no_comment);
        let result = no_comment.match("import");
        console.log('result =>',result);
        if (result!=null) {
            alert("import is NOT ALLOW !!!");
            input.value = '';
            return false;
        }

        // (fileContent.split('\n')).forEach( (ele,index) => {
        //     console.log(index,"=>",ele)
        //     console.log(index,"=>",ele.replace('\r',''))
        // })
        submitButton.disabled=false ;
        console.log("Submit button is enable.");
    }

}

// --------------------- for source code submit -------------------------------------
function form_submit(obj) {             // obj is button object located inside form
    console.log("form_submit")
    const form_to_submit = obj.form;
    obj.disabled = true;                // prevent multiple submit
    //console.log(form_to_submit);
    //checkSourceCode();
    
    // let file_content = get_file_content();
    // console.log(`File content ==> ${file_content}`);
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


// -----------------------------------------------------------------------------------------------
function get_header_content(strip_comment) {
    header_content = strip_comment;
    return header_content;
}

// 13 Sep 2020
function filecheck(input_file) {    
    //const input_file = document.querySelector('input[type="file"]');
    let reserved_words = ["False","class","return","is","finally","None" ,"if","for","lambda","continue",
                        "True","def","from","while","nonlocal","and","del","global","not","with",
                        "as","elif","try","or" ,"yield","assert","else","import","pass","break","except","in","raise"];
    let key_words=["print","input","if","for","while","else","do"];
    var fr1 = new FileReader();
    fr1.onload = function(event) {
        // The file's text will be printed here
        var text = fr1.result;
        console.log("123456 ==> "+event.target.result);
        console.log("ttt ==> "+text);
        var text = removeComments(text);
        console.log("ttt2 ==> "+text);
        let count_if = (text.match(/if/g) || []).length;
        console.log("if="+count_if);
        let count_for = (text.match(/for/g) || []).length;
        console.log("for="+count_for);
        let count_while = (text.match(/while/g) || []).length;
        console.log("while="+count_while);
        let count_do = (text.match(/do/g) || []).length;
        console.log("do="+count_do);
        let count_switch = (text.match(/switch/g) || []).length;
        console.log("switch="+count_switch);
        let count_import = (text.match(/import/g) || []).length;
        console.log("import="+count_switch);
    };
    
    // fr1.readAsText(input_file.files[0]);
    // let content1 = fr1.result;
    // console.log("01->"+content1);
    // let content2 = removeComments(content1);
    // console.log("02->"+content2);
    // console.log("03->"+fr1);
    // content1 = fr1.result;
    // console.log("04->"+content1);
    // content2 = removeComments(content1);
    // console.log("05->"+content2);
}

// 2021-03-09
/*
function activity_log() {
    console.log("infoForTracking");    console.log(infoForTracking);
    //console.log(baseURL);
    //console.log("Sending info to server");
    const data_log = {
        'server_ip':    infoForTracking['server']['SERVER_ADDR'],
        'server_port':  parseInt(infoForTracking['server']['SERVER_PORT']),
        'client_ip':    infoForTracking['server']['REMOTE_ADDR'],
        'client_port':  parseInt(infoForTracking['server']['REMOTE_PORT']),
        'page_name':    infoForTracking['session']['page_name'],
        'elapsed_time':  parseInt(infoForTracking['elapsed_time']*1000000),
        'server_uid':   infoForTracking['server']['UNIQUE_ID'],
        'ci_id':        parseInt(infoForTracking['session']['ci_session']),
        'requestTime':  infoForTracking['server']['REQUEST_TIME'],
        //'exercise_id':  parseInt(infoForTracking['session']['exercise_id'] ? infoForTracking['session']['exercise_id'] : -1),
        'exercise_id':  parseInt(infoForTracking['session']['exercise_id'] ?? -1),
        'chapter':      infoForTracking['session']['chapter_id'] ? infoForTracking['session']['exercise_id'] : -1,
        'item':         parseInt(infoForTracking['session']['item'] ?? -1),
        'remark':       JSON.stringify(infoForTracking['server'])


    };
    console.log("data_log");
    console.log(data_log);

    //fetch("http://compro.ce.kmitl.ac.th/compro20s2/index.php/plms_json/landing_page", {
    fetch("http://compro.ce.kmitl.ac.th/compro20s2/index.php/plms_json/student_activity_log", {
    //fetch("http://compro.ce.kmitl.ac.th/compro20s2/index.php/plms_json/test_json_post", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }, 
        body: JSON.stringify( {data_log} )
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    /*.catch( function (error) {
            console.log('Error:', error);
        });
}

*/

// 13 March 2021 test
function update_submission_time (time_sec,requestTime) {
    //console.log(`baseurl_ = ${baseurl_}`);
    //console.log(`user_id = ${user_id}`);
    //console.log(`user_role = ${user_role}`);
    let URL_ = baseurl_+"index.php/plms_json/get_online_student/"+user_id+"/"+user_role;
    //console.log("URL_=>"+URL_);

    fetch(URL_)
    .then( (res) => res.json() )
    .then( (data) => {
        //console.log(data);
        let online_students = 0;
        for( row of data) {
            //console.log(row);
            online_students += parseInt(row.num_students);
        }
        //console.log("online students : "+ online_students+" "+ (new Date()));
        document.querySelector("#online_students").innerHTML = `Student  online : ${online_students}`;
    });
}

// 5 October 2022
function show_midterm_score() {
    //midscore.addEventListener("dbclick");
    var URL_ = baseurl+"index.php/plms_json/get_midterm_score/"+infoForTracking.session.username+"/"+infoForTracking.session.ci_session;
    // console.log("URL_=>"+URL_);

    // fetch(URL_, {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify(infoForTracking)
    // })
    fetch(URL_)
    .then( (res) => res.json() )
    .then( (data) => {
        var stu_data = data;
        console.log(data);
        let midscore = data['mid_score'];
        console.log(`midterm score = ${midscore}`);
        const midscore_element = document.querySelector("#midterm_score");
        let previous_html = midscore_element.innerHTML;
        midscore_element.innerHTML = midscore;
        setTimeout(()=>{
            midscore_element.innerHTML=previous_html;
        },2000);
    });
}

//for testing
function test610() {
    var URL_ = baseurl+"index.php/plms_json/test/";
    console.log("URL_");
    fetch(URL_)
    .then( (res) => res.json() )
    .then( (data) => {
        console.log(data);
        for( const [key,value] of Object.entries(data)) {
            console.log(`${key} \t=> \t${value}`);
        }

    });
  
}

