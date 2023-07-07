function companyChange() {

    updateChildTableJoinField('contactperson', 'company', 'company');

    {% if document.languagepostfix == '_ru' %}
    let projectLabel = "Проект_";
    {% else %}
    let projectLabel = "Project_";
    {% endif %}

let companyObject = document.getElementById("comes_company0");
let selected_value = companyObject.value;
let nameObject = document.getElementById("comes_name");

    if (!checkIfNameIsFromCompany())
{
        return;
}

if(selected_value=="")
{
nameObject.value=""
        return;
}


    let selected_option = companyObject.querySelector('option[value="' + selected_value + '"]');
    let current_date = new Date();
    let current_year = current_date.getFullYear();

    let companyCleanName = selected_option.text;
    companyCleanName = companyCleanName.replaceAll(" ", "_");
    companyCleanName = companyCleanName.replaceAll('"', "");

    nameObject.value = projectLabel + companyCleanName + "_" + current_year;
}

function checkIfNameIsFromCompany() {

    {% if document.languagepostfix == '_ru' %}
    let projectLabel = "Проект_";
    {% else %}
    let projectLabel = "Project_";
    {% endif %}

    let nameObject = document.getElementById("comes_name");
    if (nameObject.value == '')
        return true;

    let current_date = new Date();
    let current_year = current_date.getFullYear();

    let companyObject = document.getElementById("comes_company0");
    let options = companyObject.options;

    for (let j = 0; j < options.length; j++) {

        let companyCleanName = options[j].text;
        companyCleanName = companyCleanName.replaceAll(" ", "_");
        companyCleanName = companyCleanName.replaceAll('"', "");

        if (nameObject.value == projectLabel + companyCleanName + "_" + current_year)
            return true;
    }
    return false;
}

window.onload = function () {
    let contactPersonValue = document.getElementById("comes_contactperson").value;
    companyChange()

    setTimeout(() => {
        document.getElementById("comes_contactperson").value = contactPersonValue;
        document.getElementById("comes_contactperson0").value = contactPersonValue;
    }, 2000);
};