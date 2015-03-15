function changeGroup(role)
{
    if(role || roleGroup[role])
    {
        $('#group').val(roleGroup[role]); 
    }
    else
    {
        $('#group').val(''); 
    }
}

function createCheckbox(parentID){
	var parent = document.getElementById(parentID);//获取父元素
	var specialtyInput = document.getElementById('specialtyInput');
	var classInput = document.getElementById('classInput');
	var gradeSelect = document.getElementById('gradeSelect');
	var selected_value = document.getElementById('group').value;

	if(selected_value != 'counselor')
	{
		if(document.getElementById('manager_years') != null)
			parent.deleteCell(document.getElementById('manager_years'));
		if (document.getElementById('yearBox') != null)
			parent.deleteCell(document.getElementById('yearBox'));
	}
	else if(selected_value == 'counselor')
	{
		var myDate = new Date();
		cur_year = myDate.getFullYear();

		var  thElement = document.createElement("th");
		thElement.id = "manager_years";
		if(isFirefox())
			thElement.textContent = "管理年级";
		else
			thElement.innerText = "管理年级";
		parent.appendChild(thElement);

		var  tdElement = document.createElement("td");
		tdElement.id = "yearBox";
		parent.appendChild(tdElement);
		for (var i = 0; i <= 3; i++)
		{
			var  labElement = document.createElement("label");
			labElement.setAttribute("class",'checkbox-inline');
			if(isFirefox())
				labElement.textContent = cur_year-i;
			else
				labElement.innerText = cur_year-i;
			tdElement.appendChild(labElement);
			var  inputElement = document.createElement("input"); //创建input
			inputElement.type = "checkbox";
			inputElement.name = "grade[]";
			inputElement.id = "grade[]";
			inputElement.value = cur_year-i;
			labElement.appendChild(inputElement);
		};

		document.getElementById('grade[]').checked = cur_year;
	}

	if(selected_value != 'student')
	{
		specialtyInput.deleteCell(document.getElementById('hspecialty'));
		specialtyInput.deleteCell(document.getElementById('dspecialty'));
		classInput.deleteCell(document.getElementById('hclass'));
		classInput.deleteCell(document.getElementById('dclass'));
		gradeSelect.deleteCell(document.getElementById('hgrade'));
		gradeSelect.deleteCell(document.getElementById('dgrade'));
	}
	else if(selected_value == 'student')
	{
		var  thElement1 = document.createElement("th");
		thElement1.id = "hspecialty";
		if(isFirefox())
			thElement1.textContent = "专业";
		else
			thElement1.innerText = "专业";
		specialtyInput.appendChild(thElement1);

		var  tdElement1 = document.createElement("td");
		tdElement1.id = "dspecialty";
		specialtyInput.appendChild(tdElement1);

		var  inputElement = document.createElement("input"); //创建input
		inputElement.type = "text";
		inputElement.name = "specialty";
		inputElement.id = "specialty";
		inputElement.setAttribute("class",'form-control');
		tdElement1.appendChild(inputElement);

		var  thElement2 = document.createElement("th");
		thElement2.id = "hclass";
		if(isFirefox())
			thElement2.textContent = "班级";
		else
			thElement2.innerText = "班级";
		classInput.appendChild(thElement2);

		var  tdElement2 = document.createElement("td");
		tdElement2.id = "dclass";
		classInput.appendChild(tdElement2);

		var  inputElement = document.createElement("input"); //创建input
		inputElement.type = "text";
		inputElement.name = "class";
		inputElement.id = "class";
		inputElement.setAttribute("class",'form-control');
		tdElement2.appendChild(inputElement);

		var  thElement3 = document.createElement("th");
		thElement3.id = "hgrade";
		if(isFirefox())
			thElement3.textContent = "年级";
		else
			thElement3.innerText = "年级";
		gradeSelect.appendChild(thElement3);

		var  tdElement3 = document.createElement("td");
		tdElement3.id = "dgrade";
		gradeSelect.appendChild(tdElement3);

		var  selectElement = document.createElement("select"); //创建input
		selectElement.name = "grade";
		selectElement.id = "grade";
		for (var i = 0; i < 6; i++) 
		{
			selectElement.options.add(new Option(cur_year-i,cur_year-i));
		};
		selectElement.setAttribute("class",'form-control');
		selectElement.setAttribute("required",'required');
		tdElement3.appendChild(selectElement);
	}
	
}


function isFirefox()
{
	return window.navigator.userAgent.toLowerCase().indexOf("firefox");
}