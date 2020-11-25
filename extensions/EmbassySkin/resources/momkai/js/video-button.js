(function (mw, $, window) {
  /**
   *
   * @param url
   * @returns {string|*}
   */
  function parseUrl(url) {
    var isYoutube = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|watch\?v=)([^#&?]*).*/);
    var isVimeo = url.match(/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/|groups\/([^/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/);

    if (isYoutube) {
      var id = isYoutube[2];
      return 'https://youtube.com/embed/' + id + 'rel=0&autoplay=1&enablejsapi=1';
    } else if (isVimeo) {
      var id = isVimeo[3];
      return 'https://player.vimeo.com/video/' + id + '?autoplay=1&dnt=1';
    }

    return url
  }

  function getWindowWidth() {
    return window.innerWidth || Math.max(document.documentElement.clientWidth, document.body.clientWidth)
  }

  function getWindowHeight() {
    return window.innerHeight || Math.max(document.documentElement.clientHeight, document.body.clientHeight)
  }

  function getScrollTop() {
    return window.pageYOffset
  }

  function getScrollLeft() {
    return window.pageXOffset
  }



  /**
   * Video button logic
   *
   * @param el
   */
  function videoButton(el) {

    // Old fashion bind method ...
    var _this = this;

    // Video modal properties
    this.embedURL = (el.getAttribute('href')) ? parseUrl(el.getAttribute('href')) : parseUrl(el.getAttribute('data-href'))
    this.ratio = (16 / 9);
    this.maxWidth = 1200;
    this.padding = 20;

    // Add event listener to button
    el.addEventListener('click', function(e) {
      e.preventDefault();
      if (!_this.background || !_this.player) {
        create();
        el.offsetWidth // eslint-disable-line
      }

      open()
    });

    // bind functions
    this._close = close.bind(this);
    this._onKeyDown = onKeyDown.bind(this);
    this._onResize = onResize.bind(this);

    // Add event listeners for modal
    function addEventListeners() {
      _this.background.addEventListener('click', _this._close);
      _this.close.addEventListener('click', _this._close);
      document.addEventListener('keydown', _this._onKeyDown);
      window.addEventListener('resize', _this._onResize)
    }

    // Remove events
    function removeEventListeners() {
      _this.background.removeEventListener('click', _this._close);
      _this.close.removeEventListener('click', _this._close);
      document.removeEventListener('keydown', _this._onKeyDown);
      window.removeEventListener('resize', _this._onResize)
    }

    // Create modal DOM elements
    function create() {
      _this.background = document.createElement('div');
      _this.background.classList.add('video-modal-background', 'is-hidden');

      _this.player = document.createElement('div');
      _this.player.classList.add('video-modal-player', 'is-hidden');

      _this.close = document.createElement('div');
      _this.close.classList.add('video-modal-close');
      _this.player.appendChild(_this.close);

      _this.iframe = document.createElement('iframe');
      _this.iframe.setAttribute('frameborder', '0');
      _this.iframe.setAttribute('width', '100%');
      _this.iframe.setAttribute('height', '100%');
      _this.iframe.setAttribute('allowfullscreen', true);
      _this.iframe.setAttribute('src', _this.embedURL);
      _this.player.appendChild(_this.iframe)

      document.body.appendChild(_this.background)
      document.body.appendChild(_this.player)
    }

    // Opens modal
    function open() {
      document.body.classList.add('modal-open');
      _this.background.classList.remove('is-hidden');
      _this.player.classList.remove('is-hidden');

      setPlayerSize();
      setPlayerPosition();
      addEventListeners();
      // _this.playVideo();
    }

    // Destroy modal DOM elements
    function destroy() {
      document.body.removeChild(_this.background);
      document.body.removeChild(_this.player);
      document.body.classList.remove('modal-open');

      delete _this.background;
      delete _this.player;
      delete _this.iframe;
      delete _this.close;
    }

    // Closes modal
    function close() {
      _this.background.classList.add('is-hidden');
      _this.player.classList.add('is-hidden');

      removeEventListeners();
      setTimeout(destroy.bind(this), 500);
    }

    function setPlayerSize() {
      var width = Math.min(_this.maxWidth, getAvailableWidth())
      var height = width / _this.ratio;

      if (height > getAvailableHeight()) {
        height = getAvailableHeight()
        width = height * _this.ratio
      }

      _this.player.style.width = width + 'px';
      _this.player.style.height = height + 'px';
    }

    function setPlayerPosition() {
      var top = ((getWindowHeight() - _this.player.getBoundingClientRect().height) / 2) + getScrollTop()
      var left = ((getWindowWidth() - _this.player.getBoundingClientRect().width) / 2) + getScrollLeft()

      _this.player.style.top = top + 'px';
      _this.player.style.left = left + 'px';
    }

    function getAvailableWidth() {
      var padding = 2 * _this.padding;
      return getWindowWidth() - padding
    }

    function getAvailableHeight() {
      var padding = (2 * _this.padding) + 100; // some extra space for close button
      return getWindowHeight() - padding
    }

    function onKeyDown(event) {
      if (event.key === 'Escape') {
        close()
      }
    }

    function onResize() {
      setPlayerSize()
      setPlayerPosition()
    }
  }



  // Video buttons present in the DOM
  var buttons = document.querySelectorAll('.video-button');

  // Create new video button
  for (var i = 0; i < buttons.length; i++) {
    new videoButton(buttons[i]);
  }
}(mediaWiki, jQuery, window));

