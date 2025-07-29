/* autocomplete filter for listing page */


const countries = [
  'France',
  'Germany',
  'United Kingdom'
]

document.addEventListener("DOMContentLoaded", function() {
    accessibleAutocomplete({
        element: document.querySelector('#listing-template-autocomplete-container'),
        id: 'listing-template-autocomplete',
        name: 'listing-template-autocomplete',
        displayMenu: 'overlay',
        placeholder: '',
        source: countries,
        showAllValues: true,
        dropdownArrow: function (config) {
            return '<svg class="' + config.className + '" style="top: 12px;" viewBox="0 0 512 512" ><path d="M256,298.3L256,298.3L256,298.3l174.2-167.2c4.3-4.2,11.4-4.1,15.8,0.2l30.6,29.9c4.4,4.3,4.5,11.3,0.2,15.5L264.1,380.9  c-2.2,2.2-5.2,3.2-8.1,3c-3,0.1-5.9-0.9-8.1-3L35.2,176.7c-4.3-4.2-4.2-11.2,0.2-15.5L66,131.3c4.4-4.3,11.5-4.4,15.8-0.2L256,298.3  z"/></svg>'
        },
    });
});

