function companyChange()
{

updateChildTableJoinField('contactperson', 'company','company');

{% if document.languagepostfix  == '_ru' %}
let projectLabel="Проект_";
{% else %}
let projectLabel="Project_";
{% endif %}

if(!checkIfNameIsfromCompany())
	return;
let nameObject = document.getElementById("comes_name");
let companyObject = document.getElementById("comes_company0");

let selected_value = companyObject.value;
let selected_option = companyObject.querySelector('option[value="' + selected_value + '"]');
let current_date = new Date();
let current_year = current_date.getFullYear();
nameObject.value = projectLabel + selected_option.text + "_" + current_year;
}

function checkIfNameIsfromCompany()
{

{% if document.languagepostfix  == '_ru' %}
let projectLabel="Проект_";
{% else %}
let projectLabel="Project_";
{% endif %}

let nameObject = document.getElementById("comes_name");
if(nameObject.value=='')
return true;

let current_date = new Date();
let current_year = current_date.getFullYear();

let companyObject = document.getElementById("comes_company0");
  var options = companyObject.options;

  for (var j = 0; j < options.length; j++) {
                                     if(nameObject.value == projectLabel + options[j].text + "_" + current_year)
                                     return true;
  }
                                     return false;
}
                                     
window.onload = function()
	{
let contactpersonValue = document.getElementById("comes_contactperson").value;
		companyChange()
                            
setTimeout(() => {
  document.getElementById("comes_contactperson").value = contactpersonValue;
    document.getElementById("comes_contactperson0").value = contactpersonValue;
}, 2000);
                                     
};