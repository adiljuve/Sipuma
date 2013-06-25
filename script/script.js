function confirmation(url)
{
	var linkref = url;
	if(confirm("Anda yakin?")){
		window.location.href=linkref;
	}
}

function string_space(o){
	o.value=o.value.replace(/([^a-zA-Z-0-9. ])/g,'');
}

function string_nospace(o){
	o.value=o.value.replace(/([^a-zA-Z-0-9.])/g,'');
}

function numeric_space(o){
	o.value=o.value.replace(/([^ -0-9])/g,'');
}

function numeric_nospace(o){
	o.value=o.value.replace(/([^-0-9])/g,'');
}

function white_space(o){
	o.value=o.value.replace(/^\s*|\s*$/g,'');
}

function disableEnterKey(e)
{
	 var key;     
	 if(window.event)
		  key = window.event.keyCode;
	 else
		  key = e.which;

	 return (key != 13);
}

function changeText(){
	var userInput = document.getElementById('user_type').value;
	if (userInput == "dosen"){
		document.getElementById('ID').innerHTML = 'NIP: (*)';
	}else if (userInput == "mahasiswa"){
	document.getElementById('ID').innerHTML = 'NIM: (*)';
	}else{
	document.getElementById('ID').innerHTML = '[ID]: (*)';
	}
}
		
function registration_check(form)
{
	if(form.password.value != form.password_confirmation.value){
		if((form.password.value != '') && (form.password_confirmation.value != '')){
			alert("Maaf, Password Tidak Cocok!");
			form.password_confirmation.focus();
			return false;
		}
	}
	return true;
}
				
function paper_search_check(form)
{
	if ((form.keyword.value==""))
	{
		return false;
	}else{
		form.submit();
		return true;
	}
}

function login_check(form)
{
	if ((form.user_id.value=="")||(form.password.value==""))
	{
		return false;
	}else{
		form.submit();
		return true;
	}
}

function profile_check(form)
{
	var x=document.forms["profile"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (form.email.value=="")
	{
		form.email.focus();
		return false;
	}else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		window.alert('Alamat email tidak valid');
		form.email.focus();
		return false;
	}else{
		form.submit();
		return true;
	}
}


function pass_check(form)
{
	if ((form.password_old.value=="")||(form.password_new.value=="")||(form.password_new_confirm.value==""))
	{
		return false;
	}else if ((form.password_new.value) != (form.password_new_confirm.value)){
		window.alert('Maaf, password baru yang diulangi tidak cocok.');
		form.password_new_confirm.focus();
		return false;		  
	}else{
		form.submit();
		return true;
	}
}

function subject_check(form)
{
	if (form.subject_name.value=="")
	{
		return false;	  
	}else{
		form.submit();
		return true;
	}
}

/*function journal_check(form)
{
	if ((form.journal_name.value!='')&&(form.url.value!='')&&(document.journal.subject_id.selectedIndex!=''))
	{
		if (form.info.value==''){
			window.alert('Silakan Isi Informasi mengenai Jurnal');
			form.info.focus();
			return false;	  
		}else{
			return true;
		}
	}
}*/

function journal_check(form)
{
	if ((form.journal_name.value!='')&&(form.path.value!=''))
	{
		if(document.journal["subject_id[]"].value == "")
		{
			window.alert('Pilih minimal 1 subjek');
			return false;
		}
	}
}

/*function paper_check(form)
{
	var form = document.getElementById('paper');
	var fields = form.getElementsByTagName('input');
	var filledFiles = 0;
	
	var fup = document.getElementById('file');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	for(x in fields){
	  if(fields[x].name == 'file[]' && fields[x].value != ''){
		filledFiles++;
	  }
	}
	if ((form.title.value!="") && (document.paper.journal_id.selectedIndex!=0) && (form.abstraction.value!=""))
	{
		if((filledFiles == 0)||(ext != 'pdf')){
		  window.alert('Setidaknya 1 file .pdf harus diupload!');
		  return false;
		}
	}
}*/

function paper_check(form)
{	
	var fup = document.getElementById('file');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	/*for(x in fields){
	  if(fields[x].name == 'file[]' && fields[x].value != ''){
		filledFiles++;
	  }
	}*/
	if ((form.title.value!="") && (document.paper.journal_id.selectedIndex!=0) && (form.abstraction.value!=""))
	{
		if(ext != 'pdf'){
		  window.alert('File yang diupload harus berformat .pdf!');
		  return false;
		}
	}
}

function paper_edit_check(form)
{	
	var fup = document.getElementById('file');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	for(x in fields){
	  if(fields[x].name == 'file[]' && fields[x].value != ''){
		filledFiles++;
	  }
	}
	if ((form.title.value!="") && (form.abstraction.value!=""))
	{
		if(ext != 'pdf'){
		  window.alert('File yang diupload harus berformat .pdf!');
		  return false;
		}
	}
}

function paper_edit_check(form)
{
	if ((form.title.value=="")||(form.abstraction.value==""))
	{
		return false;	  
	}else{
		form.submit();
		return true;
	}
}

function discussion_reply_check(form)
{
	if (form.comment.value=="")
	{
		form.comment.focus();
		return false;	  
	}else{
		form.submit();
		return true;
	}
}
function review_check(form)
{
	if (form.review_message.value=="")
	{
		form.review_message.focus();
		return false;	  
	}else{
		form.submit();
		return true;
	}
}

function user_check(form)
{
	var x=document.forms["user"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if ((document.user.akun.selectedIndex==0)||(form.user_id.value=="")||(form.nama_lengkap.value=="")||(document.user.jenis_kelamin.selectedIndex==0)||(form.email.value=="")||(form.password.value==""))
	{
		return false;
	}else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		window.alert('Alamat email tidak valid');
		form.email.focus();
		return false;
	}else{
		form.submit();
		return true;
	}
}

function message_check(form)
{
	if ((form.message_text.value!="")&&(form.subject.value!=""))
	{
		if(document.message["recipient"].value == "")
		{
			window.alert('Pilih minimal 1 tujuan pesan');
			return false;
		}
	}
}

function Count(){
	var karakter,maksimum;  
	maksimum = 255
	karakter = maksimum-(document.message.message_text.value.length);  
	if (karakter < 0) {
		//alert("Jumlah Maksimum Karakter:  " + maksimum + "");  
		document.message.message_text.value = document.message.message_text.value.substring(0,maksimum);  
		karakter = maksimum-(document.messaage.message_text.value.length);  
		document.message.counter.value = karakter;  
	} 
	else {
		document.message.counter.value =  maksimum-(document.message.message_text.value.length);
	}
}