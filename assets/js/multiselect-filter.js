/* Multiselect filter for listing page */

//used to check if user has selected an option then to clear on interval
var $confirmed = false;

//Clears the autocomplete field after a user has selected an option
setInterval(() => {
	if($confirmed){
		document.getElementById('hearing-witness-autocomplete').value = '';
		$confirmed = false;
		//checkMaxSelectedOptions();
	}
}, 100); 

var terms = multiselect_object.all_terms;

var selected_term_ids = multiselect_object.selected_terms;

var term_names = multiselect_object.term_names;

document.addEventListener("DOMContentLoaded", function() {
    
	accessibleAutocomplete({
		element: document.querySelector('#hearing-witness-autocomplete-container'),
		id: 'hearing-witness-autocomplete', // Matches the hidden input
		name: 'hearing-witness-autocomplete', // Matches the hidden input
		displayMenu: 'overlay',
		placeholder: 'Search for a name',
		source: function (query, populateResults) {
			const results = term_names.filter(term => term.toLowerCase().includes(query.toLowerCase()));
			populateResults(results);
		},
		showAllValues: true,
		dropdownArrow: function (config) {
			return '<svg class="' + config.className + '" style="top: 12px;" viewBox="0 0 512 512" ><path d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9  c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3  z"/></svg>'
		},
		onConfirm: (value) => {

			if (selected_term_ids.length < 6) {
		   		confirmMultiSelectOption(value);
		   		updateMultiSelectOptions();
			}
		}
	});

	//checkMaxSelectedOptions();

});

function updateMultiSelectOptions() {
	term_names = [];
	terms.forEach((term) => {
		if(!selected_term_ids.includes(term.term_id)){
			term_names.push(term.name);
		}
	});
}
//Confirms selected option
 function confirmMultiSelectOption(value) {


	const foundTerm = terms.find(item => item.name === value);

	if (foundTerm) {
   
		if(selected_term_ids.includes(foundTerm.term_id)){
			return;
		}

		$confirmed = true;

		selected_term_ids.push(foundTerm.term_id);

		document.getElementById('hearing-witness-multiselect-hidden-input').value = selected_term_ids.toString();

		const newDiv = document.createElement('div');

		newDiv.id = 'selected-option-'+foundTerm.term_id; 
		newDiv.className = 'multiselect-selected-option';

		const nameDiv = document.createElement('div');

		nameDiv.textContent = foundTerm.name;
		nameDiv.className = 'multiselect-selected-option-name';

		newDiv.appendChild(nameDiv);

		const removeDiv = document.createElement('div');

		removeDiv.innerHTML = '<button class="multiselect-selected-remove-button" type="button" aria-label="Remove selected option">Remove</button>';
		removeDiv.className = 'multiselect-selected-remove';
		removeDiv.setAttribute('data-termid', foundTerm.term_id);

		newDiv.appendChild(removeDiv);

		document.getElementById('hearing-witness-selected-options').appendChild(newDiv);

		removeDiv.addEventListener('click', () => {

			var termId = Number(removeDiv.getAttribute('data-termid'));
			removeMultiSelectOption(termId);

		});


	}
	
 }

 //Removes option from selected options
 function removeMultiSelectOption(value) {
	selected_term_ids = selected_term_ids.filter(term_id => term_id !== value);
	document.getElementById('hearing-witness-multiselect-hidden-input').value = selected_term_ids.toString();
	document.getElementById('selected-option-'+value).remove();
	updateMultiSelectOptions();
	//checkMaxSelectedOptions();
 }

 //Adds event listener to remove option - first option
 const removeOptions = document.querySelectorAll('div.multiselect-selected-remove');

 removeOptions.forEach(option => {
	option.addEventListener('click', () => {

		var termId = Number(option.getAttribute('data-termid'));
		removeMultiSelectOption(termId);

	});
});

function checkMaxSelectedOptions() {
	if (selected_term_ids.length == 6) {
		document.getElementById('hearing-witness-autocomplete').disabled = true;
		document.getElementById('hearing-witness-multiselect-warning').classList.add('show-warning');
		document.getElementById('hearing-witness-multiselect-warning').textContent = "You have reached the maximum number of names that can be applied. Remove and then re-add if you need a different name."

	}
	else{
		document.getElementById('hearing-witness-autocomplete').disabled = false;
		document.getElementById('hearing-witness-multiselect-warning').classList.remove('show-warning');
		document.getElementById('hearing-witness-multiselect-warning').textContent = "";
	}
}