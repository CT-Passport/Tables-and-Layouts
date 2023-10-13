function addEmployee(company){
	    let query = '/add-new-employee-modal-form?ismigrant=1&company='+company;
    ctEditModal(query,"migprojectbatches.temporaryEmployeeHolder");
	return false;
}

function addEmployeeToEmployeeTable(){
location.reload();
/*
    	let tableObject = document.getElementById('sqljoin_table_comes_employees');
    let newRow = tableObject.insertRow();
    // Create cells for the new row
    let cell1 = newRow.insertCell(0);
    let cell2 = newRow.insertCell(1);
    // Add content to the cells (you can add more cells if needed)
    let rowCount = tableObject.rows.length;
	    let newEmployeeId = document.getElementById('comes_temporaryEmployeeHolder').value;

    cell1.innerHTML = '<input type="checkbox" name="comes_employees[]" id="comes_employees_' + rowCount + '" value="' + newEmployeeId +'" checked="checked" data-type="records">';
    cell2.innerHTML = '<label for="comes_employees_' + rowCount +'">Abezyan<br>Obezyanovich</label>';
*/
}