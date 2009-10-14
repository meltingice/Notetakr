function modalBox(content,width,height)
{
	var modalcontent = $('modalcontent');
	var extracontent = $('extracontent');
	extracontent.innerHTML = '';
	
	setModalDimensions(width,height);
	
	if(content == 'organizer help')
	{
		modalcontent.innerHTML = "<ul style=\"text-align:left;list-style:none;padding-left:10px;\"><li><p><img src=\"img/bullet_go.png\" alt=\"go\" />&nbsp;Click and drag to organize notes</p></li><li><p><img src=\"img/note_edit.png\" alt=\"edit\" />&nbsp;Click to edit a note's title</p></li><li><p><img src=\"img/note_delete.png\" alt=\"delete\" />&nbsp;Click to delete a note</p></li><li><p><img src=\"img/folder_edit.png\" alt=\"edit\" />&nbsp;Click to edit a folder's name</p></li><li><p><img src=\"img/folder_delete.png\" alt=\"delete folder\" />&nbsp;Click to delete a folder.  More options after click.</p></li></ul>";
	}	
	else
	{
		modalcontent.innerHTML = "<p>"+content+"</p>";
	}
	
}

function modalInitialSaveBox(content,width,height)
{
	var modalcontent = $('modalcontent');
	
	setModalDimensions(width,height);
	
	modalcontent.innerHTML = "<p>"+content+"</p>";
	new Ajax.Updater('extracontent','includes/notefunctions.php?folderlist=true',{method:'get',asynchronous:true});
}

function modalNewFolder(content,width,height)
{
	var modalcontent = $('modalcontent');
	var extracontent = $('extracontent');
	
	setModalDimensions(width,height);
		
	modalcontent.innerHTML = "<p>"+content+"</p>";
	
	var form = "<form method='post' action='includes/folderfunctions.php' name='newfolderform'>";
	form += "<p>Name: <input type='text' name='newfolder' /></p>";
	form += "<p><input type='submit' value='Go' /></p>";
	form += "</form>";
	
	extracontent.innerHTML = form;
}

function modalDeleteBox(content,width,height,ID,item)
{
	var modalcontent = $('modalcontent');
	var extracontent = $('extracontent');

	setModalDimensions(width,height);
	
	modalcontent.innerHTML = "<p>"+content+"</p>";

	if(item=='note')
	{
		extracontent.innerHTML = "<p><a href=\"includes/notefunctions.php?deletenote="+ID+"\">Yes</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:modalClose()\">No</a></p>";
	}
	else if(item=='folder')
	{
		extracontent.innerHTML = "<p style=\"margin: 30px 0 30px 0\"><a href=\"includes/folderfunctions.php?deletefolder="+ID+"&move=false\">Delete folder & contents</a></p><p style=\"margin: 30px 0 30px 0\"><a href=\"includes/folderfunctions.php?deletefolder="+ID+"&move=true\">Delete folder & move contents to Uncategorized</a></p><p style=\"margin: 30px 0 30px 0\" ><a href=\"javascript:modalClose()\">Do not delete</a></p>";
	}
}

function modalEditBox(content,width,height,ID,item,name)
{
	var modalcontent = $('modalcontent');
	var extracontent = $('extracontent');
	
	setModalDimensions(width,height);
	
	modalcontent.innerHTML = "<p>"+content+"</p>";
	
	if(item=='note')
	{
		var form = "<form method='post' action='includes/notefunctions.php' name='notefunctions'>";
		form += "<p>Name: <input type='text' name='editnote' value='"+name+"' /></p>";
		form += "<p><input type='submit' value='Go' /></p>";
		form += "<input type='hidden' value='"+ID+"' name='noteID' />"
		form += "</form>";
		
		extracontent.innerHTML = form;
	}
	else if(item=='folder')
	{
		var form = "<form method='post' action='includes/folderfunctions.php' name='editfolderform'>";
		form += "<p>Name: <input type='text' name='editfolder' value='"+name+"' /></p>";
		form += "<p><input type='submit' value='Go' /></p>";
		form += "<input type='hidden' value='"+ID+"' name='folderID' />"
		form += "</form>";
		
		extracontent.innerHTML = form;
	}
}

function setModalDimensions(width,height)
{
	var modaldiv = $('modaldiv');
	var modalbox = $('modalbox');
	modalbox.style.width = width+"px";
	modalbox.style.height = height+"px";
	
	var topMargin = returnWindowSize();
	modalbox.style.marginTop = (topMargin[1]/2)-(height/2)+"px";
	
	modaldiv.style.display = "block";
}

function modalClose()
{
	var modaldiv = $('modaldiv');
	modaldiv.style.display = "none";
}