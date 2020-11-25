/**
 * Set initial tab active
 */
document.addEventListener('DOMContentLoaded', (event) => {
  var tabs = document.querySelectorAll('.g-tablinks:not(.disabled)');

  if(tabs.length) {
    // Set first tab that is enabled
    tabs[0].classList.add('active');
  }
})

/**
 * Module to open links inside MediaWiki context
 */
var tabs = document.querySelectorAll('.g-tablinks');
if(tabs) {
  tabs.forEach(function(tab) {

    tab.addEventListener('click', function(e) {
      var trainerTab = document.querySelector('[data-tab="trainer"]');
      var traineeTab = document.querySelector('[data-tab="trainee"]');
  
      if (e.target.dataset.tab === 'trainer') {
        trainerTab.classList.add('active');
        traineeTab.classList.remove('active');
        document.querySelector('#data-tab-content-trainer').style.display = 'block';
        document.querySelector('#data-tab-content-trainee').style.display = 'none';
      }
  
      if (e.target.dataset.tab === 'trainee') {
        traineeTab.classList.add('active');
        trainerTab.classList.remove('active');
        document.querySelector('#data-tab-content-trainer').style.display = 'none';
        document.querySelector('#data-tab-content-trainee').style.display = 'block';
      }
    })
  })
}