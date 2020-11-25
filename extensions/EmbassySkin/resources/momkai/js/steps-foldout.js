/**
 * Module to open links inside MediaWiki context
 */
$('.steps-foldout-toggle').on('click', function(e) {
  e.preventDefault();

  const stepsContainer = this.closest('.steps-foldout-container')

  stepsContainer.classList.toggle('is-open')

});
