function checkEmpty(data)
{
	if(data === '')
	{
		return 0;
	}
	else
	{
		return 1;
	}
}

function checkDirection(data)
{
	if(checkEmpty(data) == 0)
	{
		return 0;
	}
	else
	{
		//var pattern = '\^[0-9]{2}[.][0-9]{2}[.][0-9]{2}$\u';
		var pattern = '/^[0-9]{2}[.][0-9]{2}[.][0-9]{2}$/';
		if(pattern.test($data) == false)
		{
			return 2;
		}
		else
		{
			return 1;
			alert(33333);
		}
	}
}

function checkText(data)
{
	if(checkEmpty(data) == 0)
	{
		return 0;
	}
	else
	{
		//var pattern = '/^[0-9]{2}[.][0-9]{2}[.][0-9]{2}$/u';
		if(data.length > 255)
		{
			return 2;
		}
		else
		{
			return 1;
		}
	}
}