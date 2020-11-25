/**
 * Module to add readmore
 */
$(function () {

  const charThreshold = 280
  const allHasReadMore = $('.has-readmore');
  const readMore = '<span class=\"read-more\">Read more</span>'

  $.each(allHasReadMore, function (index, hasReadMore) {
    // Insert readmore button when string is greater than charThreshold
    if (hasReadMore.innerText.length > charThreshold) {

      const readMoreEl = $(readMore).insertAfter(hasReadMore);

      $(readMoreEl).on('click', function (e) {
        $(this).hide()
        $(hasReadMore).addClass('open')
      })
    } else {
      $(hasReadMore).addClass('readmore-disabled')
    }

  });
});
