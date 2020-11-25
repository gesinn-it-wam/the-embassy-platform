/**
 * Polyfill for ChildNode.remove()
 * More: https://developer.mozilla.org/en-US/docs/Web/API/ChildNode/remove
 */
(function (arr) {
  arr.forEach(function (item) {
    if (item.hasOwnProperty('remove')) {
      return;
    }
    Object.defineProperty(item, 'remove', {
      configurable: true,
      enumerable: true,
      writable: true,
      value: function remove() {
        if (this.parentNode === null) {
          return;
        }
        this.parentNode.removeChild(this);
      }
    });
  });
})([Element.prototype, CharacterData.prototype, DocumentType.prototype]);

/**
 * After Drilldown is loaded this javascript will do some cleaning
 * on the DOM.
 */
// DOM drilldown header
var drilldownHead = document.querySelector('#drilldown-header')

// DOM drilldown form filters
var drilldownFilters = document.querySelector('div.drilldown-filters')
if(drilldownFilters) {
  var drilldownForms = drilldownFilters.querySelectorAll('form')
}

/**
 * Generate see more button
 */
var seeMoreFilters = function() {
  var element = document.createElement('div')
  element.className = 'drilldown-seeMore'
  element.innerHTML = '<label for="drilldown-seeMore">Filters</label>'

  var checkbox = document.createElement('input')
  checkbox.type = "checkbox"
  checkbox.id = "drilldown-seeMore"
  checkbox.className = "drilldown-seeMore-checkbox"

  drilldownFilters.insertBefore(checkbox, drilldownFilters.querySelectorAll('.drilldown-filter')[0])
  drilldownFilters.appendChild(element)
}

/**
 * This method created some simple funcionality on current drilldown forms
 *
 * @param element
 * @constructor
 */
var FormDrilldown = function(element) {

  if(!element) return

  // get DOM elements from forms
  var el = element
  var submit = el.querySelector('input[type="submit"]')
  var select = el.querySelector('select')
  var label = el.querySelector('select ~ input[type="text"]')
  var automcompleteTrigger = el.querySelector('button')

  // Make sure the button automcomplete trigger has correct classenames
  automcompleteTrigger.classList.remove('ui-button', 'ui-widget', 'ui-state-default', 'ui-button-icon-only')
  automcompleteTrigger.innerHTML = ''

  // @todo to disable in server
  // select.removeAttribute('style')

  // console.log(el);
  // console.log(select);
  // console.log(submit);
  // console.log(label);
  // console.log('--')

  // detect change on select element
  // label.addEventListener('input', function() {
  //   console.log('trigger input in label', label)
  //   console.log(label.value)
  //   // trigger submit button
  //   // submit.click()
  // })

  // label.addEventListener('change', function() {
  //   console.log('trigger change in label', label)
  //   console.log(label.value)
  //   // trigger submit button
  //   submit.click()
  // })
}

/**
 * This method cleans unnecessary code on the selected filters
 *
 */
var cleanupSelectedFilters = function() {
  var selectedTags =  drilldownHead.querySelectorAll('.drilldown-header-value')

  // Create see more filters
  seeMoreFilters()

  // We loop over the selected filters to clean these
  for (i = 0; i < selectedTags.length; i++) {

    // if selected filter has only an '&' we remove this from the DOM
    if (selectedTags[i].innerText === '&') {
      selectedTags[i].remove()

      // if the filter is a selection we remove the first 3 characters and the last one so that
      // we can see the correct selection
    } else {

      // Remove ' or " from the end of selected filter values
      if(selectedTags[i].innerText[selectedTags[i].innerText.length - 1] === ("'" || '"')) {
        selectedTags[i].innerText = selectedTags[i].innerText.substr(0, selectedTags[i].innerText.length - 1)
      }

      // remove `~ '` from string
      // @todo not sure why the string was being added in the name of the filter
      if(selectedTags[i].innerText.substr(0, 3) === "~ '") {
        selectedTags[i].innerText = selectedTags[i].innerText.substr(3)
      }
    }
  }

  drilldownHead.classList.add('is-visible')
  drilldownFilters.classList.add('is-visible')
}

// We use a setTimeout to wait for the DOM to be loaded
setTimeout(function(){

  if(!drilldownFilters) return;

  // On load we do a clean up on selected filters
  // The purpose is to remove inconsistences from SMW / Drilldown Filters
  cleanupSelectedFilters()

  // Detect change on select dropdown
  for(i = 0; i < drilldownForms.length; i++) {
    new FormDrilldown(drilldownForms[i])
  }

}, 500)

