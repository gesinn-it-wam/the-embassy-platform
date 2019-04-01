( function (mw , $ ) {
    'use strict';
    // Module to be tested.
    var DTP2 =   mw.ext.datetimepicker2;
     QUnit.module( 'ext.datetimepicker2.module', QUnit.newMwEnvironment() );

     /*
      * zeroPad
      * convert24TimeFormat
      * getFormatedUserOffset
      * getISOTimeWithTimezone
      * getUTCDate
      * mwMessages
      */

 QUnit.test( "Test  getFormatedUserOffset", function( assert) {
 assert.equal( DTP2.getFormatedUserOffset("-150"), "-02:30");
 assert.equal( DTP2.getFormatedUserOffset("300"),  "+05:00" );
 });


    QUnit.test( "Test ZeroPad", function( assert) {
        assert.equal( DTP2.zeroPad(12, 2), "12" );
        assert.equal( DTP2.zeroPad(8, 2), "08" );
    });

    QUnit.test( "Test convert24TimeFormat", function( assert) {
        assert.equal( DTP2.convert24TimeFormat("02:30 pm"), "14:30" );
        assert.equal( DTP2.convert24TimeFormat("12:00"), "12:00" );
    });


    QUnit.test( "Test  getISOTimeWithTimezone", function( assert) {

        assert.equal(  DTP2.getISOTimeWithTimezone("2017-07-06 12:30 +0200"), "2017-07-06T12:30+02:00"  );
        assert.equal( DTP2.getISOTimeWithTimezone("2017-07-06 07:30 pm -0500"),"2017-07-06T19:30-05:00" );
        assert.equal( DTP2.getISOTimeWithTimezone("2017-07-06 02:30:00 am -0500"),"2017-07-06T02:30:00-05:00" );
    });

    QUnit.test( "Test  getUTCDate", function( assert) {

        assert.equal(  DTP2.getUTCDate("2017-07-06 12:30 +0200"), "2017-07-06T10:30+00:00"  );
        assert.equal( DTP2.getUTCDate("2017-07-06 12:30 -0500"),  "2017-07-06T17:30+00:00" );
    });


})( mediaWiki, jQuery);