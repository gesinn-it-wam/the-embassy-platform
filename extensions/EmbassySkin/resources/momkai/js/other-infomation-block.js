window.addEventListener('DOMContentLoaded', function(event) {
  /**
   * This module uses masonry from https://masonry.desandro.com/
   */
  var elem = document.querySelector('.other-information-grid');

  if(elem) {
    var msnry = new Masonry( elem, {
      itemSelector: '.other-information-block',
      percentPosition: true,
      gutter: 10
    });
  }

// Grab number of grid items
  var gridItems = document.querySelectorAll('.grid-block');

  if(gridItems) {
    // Set collapse of grid items
    for (var i = 0; i < gridItems.length; i++) {
      console.log(gridItems[i])
      new gridBlock(gridItems[i], msnry);
    }
  }

// Created grid elements block
// Used by other-information-block and related-discussion components
  function gridBlock(el, msnry) {
    this.el = el;
    this.trigger = this.el.querySelector('.grid-item-last');
    this.items = this.el.querySelectorAll('.grid-item');
    this.length = this.el.querySelectorAll('.grid-item').length;
    this.msnry = msnry

    var open = function(e) {
      e.preventDefault()
      this.trigger.classList.remove('is-visible')

      for (var i = 3; i < this.items.length; i++) {
        this.items[i].classList.remove('is-hidden');
      }

      // Lays out all item elements.
      // See https://masonry.desandro.com/methods.html#layout
      this.msnry.layout()

      setTimeout(cleanup, 100)
    }.bind(this);

    var cleanup = function(e) {
      this.trigger.removeEventListener('click', open)
    }.bind(this)

    if(this.length > 3) {
      this.trigger.querySelector('a').innerHTML = "+ "+ (this.length-3) +" more";
      this.trigger.classList.add('is-visible');

      for (var i = 3; i < this.items.length; i++) {
        this.items[i].classList.add('is-hidden')
      }

      this.trigger.addEventListener('click', open);
    }
  }
});
