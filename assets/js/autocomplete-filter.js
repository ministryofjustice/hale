/* Autocomplete filter for listing page */
var taxonomies_with_terms = {};

// Check if the object exists and extract terms
if (typeof listing_page_object !== 'undefined') {
    // Store taxonomy terms
    Object.entries(listing_page_object.taxonomies).forEach(([taxonomy_name, taxonomy_terms]) => {
        taxonomies_with_terms[taxonomy_name] = taxonomy_terms;
    });
}

// Function to update subtopic dropdown when parent term is selected
function updateSubtopicDropdown(taxonomy_name, parent_term_id, container) {
    const hasSubtopics = container.getAttribute('data-has-subtopics') === '1';
    
    if (!hasSubtopics) return;
    
    const childClass = container.getAttribute('data-child-class');
    const wrapper = document.getElementById(childClass + '-wrapper');
    const subtopicSelect = document.getElementById(childClass);
    
    if (!wrapper || !subtopicSelect) {
        console.warn(`Subtopic elements not found for ${taxonomy_name}`);
        return;
    }
    
    // Clear existing options
    subtopicSelect.innerHTML = '<option value="0">Select option</option>';
    
    if (parent_term_id && parent_term_id !== '0') {
        // Get child terms for the selected parent
        const childTerms = taxonomies_with_terms[taxonomy_name]
            ?.filter(term => term.parent == parent_term_id) || [];
        
        if (childTerms.length > 0) {
            // Show subtopic dropdown and enable it
            wrapper.classList.remove('govuk-visually-hidden');
            subtopicSelect.removeAttribute('disabled');
            
            // Add child options
            childTerms.forEach(term => {
                const option = document.createElement('option');
                option.value = term.term_id;
                option.textContent = term.name;
                subtopicSelect.appendChild(option);
            });
        } else {
            // Hide subtopic dropdown if no children
            wrapper.classList.add('govuk-visually-hidden');
            subtopicSelect.setAttribute('disabled', 'disabled');
        }
    } else {
        // Hide subtopic dropdown when no parent selected
        wrapper.classList.add('govuk-visually-hidden');
        subtopicSelect.setAttribute('disabled', 'disabled');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Find all autocomplete containers
    const containers = document.querySelectorAll('[id^="listing-template-autocomplete-container-"]');
    
    containers.forEach(container => {
        const taxonomy_name = container.getAttribute('data-taxonomy');
        const selected_name = container.getAttribute('data-selected-name');
        const exclude_terms = container.getAttribute('data-exclude-terms');
        const has_subtopics = container.getAttribute('data-has-subtopics') === '1';
        const show_option_all = container.getAttribute('data-show-option-all');
        
        if (!taxonomy_name) {
            console.warn('No taxonomy name found for container:', container);
            return;
        }
        
        // Get terms for this taxonomy
        let taxonomy_terms = taxonomies_with_terms[taxonomy_name] || [];
        
        // Filter out excluded terms if needed
        if (exclude_terms && exclude_terms !== '') {
            const excludeIds = exclude_terms.split(',').map(id => parseInt(id.trim()));
            taxonomy_terms = taxonomy_terms.filter(term => !excludeIds.includes(parseInt(term.term_id)));
        }
        
        // For hierarchical taxonomies, only show parent terms in autocomplete
        let source_terms; 
        if (has_subtopics) {
            source_terms = taxonomy_terms
                .filter(term => term.parent == 0) // Only parent terms
                .map(term => term.name);
        } else {
            source_terms = taxonomy_terms.map(term => term.name);
        }
        
        function validateAndGetValue(input) {
            if (!input) return '';
            const value = input.value?.trim() || '';
            return value && source_terms.includes(value) ? value : '';
        }
        
        // Function to update hidden input (shared between all handlers)
        function updateHiddenInput(selectedValue) {
            // Determine what value to set
            let valueToSet = '';
            let subtopicValue = '';
            
            // If we have a valid value, try to find the term
            if (selectedValue && selectedValue.trim() !== '') {
                const selectedTerm = taxonomy_terms.find(term => term.name === selectedValue);
                if (selectedTerm) {
                    valueToSet = selectedTerm.term_id;
                    subtopicValue = selectedTerm.term_id;
                }
            }
            
            // Update the hidden input (always, whether clearing or setting)
            const hiddenInput = document.getElementById(`listing-template-hidden-input-${taxonomy_name}`);
            if (hiddenInput) {
                hiddenInput.value = valueToSet;
                hiddenInput.dispatchEvent(new Event('change'));
            } else {
                console.warn(`Hidden input not found for ${taxonomy_name}`);
            }
            
            // Update subtopic dropdown (always, whether clearing or setting)
            if (has_subtopics) {
                updateSubtopicDropdown(taxonomy_name, subtopicValue, container);
            }
        }
        
        // Form submission helper
        function submitFormDelayed(delay = 50) {
            setTimeout(() => {
                const form = container.closest('form');
                if (form) {
                    form.submit();
                } else {
                    console.warn('Form not found for submission');
                }
            }, delay);
        }
        
        // Create the autocomplete widget
        accessibleAutocomplete({
            element: container,
            id: `listing-template-autocomplete-${taxonomy_name}`,
            name: `listing-template-autocomplete-${taxonomy_name}`,
            displayMenu: 'overlay',
            placeholder: show_option_all || 'Select option',
            defaultValue: selected_name || '',
            source: function (query, populateResults) {
                const results = source_terms.filter(term => 
                    term.toLowerCase().includes(query.toLowerCase())
                );
                populateResults(results);
            },
            showAllValues: true,
            dropdownArrow: function (config) {
                return `<svg class="${config.className}" 
                             style="width: 12px; height: 12px; top: 16px;" 
                             viewBox="0 0 512 512">
                            <path d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9
                                     c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3z"/>
                        </svg>`;
            },
            onConfirm: (selectedValue) => {
                updateHiddenInput(selectedValue);
            },

        });
        
        // Add event listeners with consistent validation
        const autocompleteInput = container.querySelector('input[type="text"]');
        if (autocompleteInput) {
            // Update hidden input when autocomplete input loses focus
            autocompleteInput.addEventListener('blur', () => {
                const validValue = validateAndGetValue(autocompleteInput);
                updateHiddenInput(validValue);
            });
            
            // Update hidden input when user presses Enter
            autocompleteInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const validValue = validateAndGetValue(autocompleteInput);
                    updateHiddenInput(validValue);
                    submitFormDelayed(100);
                }
            });
        }
        
        // Add form submit handler to ensure hidden input is updated before submission
        const form = container.closest('form');
        if (form) {
            form.addEventListener('submit', (e) => {
                const autocompleteInput = container.querySelector('input[type="text"]');
                const validValue = validateAndGetValue(autocompleteInput);
                
                if (validValue) {
                    e.preventDefault();
                    updateHiddenInput(validValue);
                    submitFormDelayed();
                }
            });
        }
    });
});

