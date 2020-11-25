(function (mw, $) {
    // Extension Namespance.
    mw.ext = mw.ext || {};
    // My App Namespace. datetimepicker2.

    mw.ext.datetimepicker2 = {
        dtp2_objects: $('.datetimepicker2'),
        /*
         *  Main function to run this application.
         */
        init: function () {

            try {

                if (!this.dtp2_objects instanceof Array) throw "Datetimepicker2 object is not an Array";

                for (i = 0; i < this.dtp2_objects.length; i++) {
                    if (this.dtp2_objects[i] == null) throw "Object is null";
                    var input_id = this.dtp2_objects[i].id;

                    if (input_id == null) throw "Input Id is null";
                    input_id.trim();

                    // initialized datetimepicker input button elements.
                    this.intalizeDateTimePicker2Button();

                    var multi_instance_obj = $("#" + input_id).closest("div.multipleTemplateStarter");

                    if (multi_instance_obj instanceof Array) throw "Multi instance template starter is null";

                    // Dont initialize input of multi instance starter
                    if (multi_instance_obj.length == 0) {
                        // initialized datetimepicker input elements.
                        this.intalizeDateTimePicker2(input_id);
                    }

                } // For-Loop End
                this.onpfFormSubmit();

            } catch (err) {
                console.log("Error from (init)" + err.message);
            }
        },

        /*
         * Helper function to convert inputformat into UTC datetimeformat before form is post
         */
        onpfFormSubmit: function () {

            $('#pfForm').submit(function (e) {

                // e.preventDefault();

                /*
                 * Get all visible input elements associated with .datetimepicker2
                 * including newly created inputs objects.
                 */
                try {

                    var dtp2_objects_visible = $('.datetimepicker2:visible');
                    if (!dtp2_objects_visible instanceof Array) throw "Datetimepicker2 object is not a visible Array"
                    /*
                     * Loop through them and check the relevant applied constrain
                     * This coming from set parameters. found in mw.config.get
                     * These constrains are unique to multi-template instances(
                     *  ( one constains on many multi-template of the same type) need filtering
                     */

                    for (i = 0; i < dtp2_objects_visible.length; i++) {

                        if (dtp2_objects_visible[i] == null) throw "Visible Input Id is null";

                        var input_id = dtp2_objects_visible[i].id;

                        var DTP2 = mw.config.get(mw.ext.datetimepicker2.getMultiStarterInputID(input_id));

                        if (DTP2 == null) throw "config variables are empty";

                        var input_id_val = $('#' + input_id).val().trim();

                        //if( dtp2_objects_visible[i] == null ) throw "Visible Input Id is null"

                        // filter inputs that have values to be saved, otherwise set them to empty string to be handle by php side,
                        // TODO could also check for the length if possible??
                        if (input_id_val.length > 0) {
                            // if timezone is false, calculate the new time based on UTC
                            if (DTP2.include_timezone == false) {

                                var userOffset = mw.ext.datetimepicker2.getFormatedUserOffset(mw.config.get('wgUserOffset'));
                                var dtformat = input_id_val + " " + userOffset;
                                var utcDateTime = mw.ext.datetimepicker2.getUTCDate(dtformat, DTP2.include_seconds);
                                $('#' + input_id + '_hidden').val(utcDateTime);
                            } else {
                                $('#' + input_id + '_hidden').val(mw.ext.datetimepicker2.getISOTimeWithTimezone($('#' + input_id).val()));
                            }
                        } else {
                            // set value to empty string to be handle by php side
                            $('#' + input_id + '_hidden').val('');
                        }

                    } // forloop ends
                    return true;

                } catch (err) {
                    console.log("Error from (submit)" + err.message);
                }
            });
        },

        /*
         * Helper function to trigger Calender when button icon is click
         * @param string input_id  button id
         */
        intalizeDateTimePicker2Button: function () {
            $('.form-template-wrapper').on('click', ".ui-datepicker-trigger", function () {
                $(this).prev('.datetimepicker2').trigger('focus');
            });

            // Rebind Handler to input field by clicking "add another" Multi Instance Template
            $('.form-template-wrapper').on('click mouseleave', '.multipleTemplateAdder, a.addAboveButton', function () {

                var dtp2_input_multi = $(this).closest('.form-template-wrapper').find('input.datetimepicker2').filter(":visible");

                if (dtp2_input_multi.length > 0) {
                    for (var k = 0; k < dtp2_input_multi.length; k++) {
                        mw.ext.datetimepicker2.intalizeDateTimePicker2($(dtp2_input_multi[k]).attr("id"));
                    }
                }
            });
        },
        /*
         * Convert any DatetimeFormat to UTC datetimeformat
         * @param string datetimeformat
         * @return string utcdatetimeformat
         */
        getUTCDate: function (datetimeformat, include_seconds) {
            try {
                if (datetimeformat === undefined) throw "Error undefined time format";
                var d = new Date(datetimeformat);

                var utc_year = d.getUTCFullYear(),
                    utcmonths = d.getUTCMonth() + 1,
                    utcdays = d.getUTCDate(),
                    utchours = d.getUTCHours(),
                    utcminutes = d.getUTCMinutes(),
                    utcseconds = d.getUTCSeconds();

                var utcdate = utc_year + '-' + this.zeroPad(utcmonths, 2) + '-' + this.zeroPad(utcdays, 2),
                    utcdatehour = this.zeroPad(utchours, 2) + ':' + this.zeroPad(utcminutes, 2);
                if (include_seconds) {
                    utcdatehour += ':' + this.zeroPad(utcseconds, 2);
                }
                return utcdate + 'T' + this.convert24TimeFormat(utcdatehour) + "+00:00";

            } catch (err) {
                console.log("Error from (getUTCDate)" + err.message);
            }

        },

        getISOTimeWithTimezone: function (dateTimeStr) {
            try {
                if (dateTimeStr == "") throw "dateTimeStr is empty string";

                if (dateTimeStr == null) throw "dateTimeStr is null";
                // 2017-05-10 10:30:00 pm -0900
                // 2017-05-10 10:30 pm -0900
                var restime = dateTimeStr.replace(/ /g, '');

                // Get the date 2017-05-10 and length.
                var ctfdate = restime.substr(0, 10),
                    timelen = restime.length;
                if (ctfdate.length !== 10) throw "wrong ctfdate format";

                // get the offset
                var ctfoffset = restime.substr(timelen - 5, timelen);
                if (ctfoffset.length !== 5) throw "ctfoffset length is not correct";
                //+0500 -> +05:00 format offset
                ctfoffset = ctfoffset.substr(0, 3) + ':' + ctfoffset.substr(3, 5);
                //return ctfoffset;

                // Get Hour:mm:sspm or Get Hour:mm:ssam
                var hhmmss = restime.substr(10, timelen);
                hhmmss = hhmmss.substr(0, hhmmss.length - 5);

                // Check lenth to find seconds.
                var ctfseconds = '';
                if (hhmmss.length > 7) {
                    ctfseconds = hhmmss.substr(5, 3);
                }

                // Get Hour:mmpm or Get Hour:mmam
                var hourampm = hhmmss.substr(0, 5) + " ";

                // Convert am or pm to 24hour time
                if (hhmmss.indexOf('am') > -1 || hhmmss.indexOf('pm') > -1) {
                    hourampm += hhmmss.substr(hhmmss.length - 2, 2);
                    hourampm = this.convert24TimeFormat(hourampm);
                }
                return ctfdate.trim() + 'T' + hourampm.trim() + ctfseconds + ctfoffset;
            } catch (err) {
                console.log("Error from (getISOTimeWithTimezone)" + err.message);
            }
        },

        /*
         * convert input time with am and pm into 24 hour format e.g 02:00 pm  == 14:00
         */
        convert24TimeFormat: function (time) {
            //return time;
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);

            if (time.indexOf('am') > -1 || time.indexOf('pm') > -1) {
                var AMPM = time.match(/\s(.*)$/)[1];
                if (AMPM == "pm" && hours < 12) hours = hours + 12;
                if (AMPM == "am" && hours == 12) hours = hours - 12;
                var sHours = hours.toString();
                var sMinutes = minutes.toString();
                if (hours < 10) sHours = "0" + sHours;
                if (minutes < 10) sMinutes = "0" + sMinutes;
                result = sHours + ":" + sMinutes;
            } else {
                result = time;
            }
            return result;
        },

        /*@param string userOffset
         *@return string  uoffs_result format -02:30
         */
        getFormatedUserOffset: function (userOffset) {
            try {
                // if userOffset is -150, return string should be -02:30
                if (isNaN(userOffset)) throw "userOffset is Not a number";

                var uoffs_result = ( Math.sign(userOffset) == -1 ) ? '-' : '+';
                // remove the sign
                userOffset = Math.abs(userOffset);
                uoffs_result += this.zeroPad(Math.floor(userOffset / 60), 2);
                uoffs_result += ':';
                uoffs_result += this.zeroPad(userOffset % 60, 2);

                return uoffs_result;
            } catch (err) {
                console.log("Error from getFormatedUserOffset" + err.message);
            }
        },

        getMultiStarterInputID: function (input_id) {
            if (input_id.match(/^input_[\d]+_DTP2_[\d]+/) !== null) {
                input_id = input_id.replace(/_[\d]+/, '');
            }
            return input_id;
        },

        /*
         * Use this function to initialized or setup Javascript for the defined input elements
         * @param string | input_id  unique id of input field.
         * @return boolen | true;
         */
        intalizeDateTimePicker2: function (input_id) {
            var input_id_multi_inst_starter = mw.ext.datetimepicker2.getMultiStarterInputID(input_id);
            // check if id contain <UnderScore><Number>
            // Example: input_4_DTP2_23
            // This Pattern is found when input is part of Multi Instance Template
            var DTP2 = mw.config.get(input_id_multi_inst_starter);
            // datetimepicker main config
            $('#' + input_id).datetimepicker({
                controlType: 'slider',
                timeFormat: DTP2.time_format,
                dayNames: this.mwMessages.dayNames,
                dayNamesMin: this.mwMessages.dayNamesMin,
                monthNames: this.mwMessages.monthNames,
                dayNamesShort: this.mwMessages.dayNamesShort,
                timezoneList: mw.config.get('wgTimezones'),
                showHour: true,
                showMinute: true,
                showSecond: DTP2.include_second,
                stepHour: DTP2.step_hour,
                stepMinute: DTP2.step_minute,
                dateFormat: "yy-mm-dd"
            });


        },

        /*
         * Add Zero to numbers less than 10.
         */
        zeroPad: function (num, places) {
            var zero = places - num.toString().length + 1;
            return Array(+(zero > 0 && zero)).join("0") + num;
        },
        /*
         * Defined messages object configure in i18n messages. this takes care of language issues.
         */
        mwMessages: {
            dayNames: [
                mw.message('dtp2-dayNames-sunday').text(),
                mw.message('dtp2-dayNames-monday').text(),
                mw.message('dtp2-dayNames-tuesday').text(),
                mw.message('dtp2-dayNames-wednesday').text(),
                mw.message('dtp2-dayNames-thursday').text(),
                mw.message('dtp2-dayNames-friday').text(),
                mw.message('dtp2-dayNames-saturday').text()
            ],
            dayNamesMin: [
                mw.message('dtp2-dayNamesMin-sunday').text(),
                mw.message('dtp2-dayNamesMin-monday').text(),
                mw.message('dtp2-dayNamesMin-tuesday').text(),
                mw.message('dtp2-dayNamesMin-wednesday').text(),
                mw.message('dtp2-dayNamesMin-thursday').text(),
                mw.message('dtp2-dayNamesMin-friday').text(),
                mw.message('dtp2-dayNamesMin-saturday').text()
            ],
            monthNames: [
                mw.message('dtp2-monthNames-January').text(),
                mw.message('dtp2-monthNames-February').text(),
                mw.message('dtp2-monthNames-March').text(),
                mw.message('dtp2-monthNames-April').text(),
                mw.message('dtp2-monthNames-May').text(),
                mw.message('dtp2-monthNames-June').text(),
                mw.message('dtp2-monthNames-July').text(),
                mw.message('dtp2-monthNames-August').text(),
                mw.message('dtp2-monthNames-September').text(),
                mw.message('dtp2-monthNames-October').text(),
                mw.message('dtp2-monthNames-November').text(),
                mw.message('dtp2-monthNames-December').text()
            ],
            dayNamesShort: [
                mw.message('dtp2-daynamesmin-sunday').text(),
                mw.message('dtp2-daynamesmin-monday').text(),
                mw.message('dtp2-daynamesmin-tuesday').text(),
                mw.message('dtp2-daynamesmin-wednesday').text(),
                mw.message('dtp2-daynamesmin-thursday').text(),
                mw.message('dtp2-daynamesmin-friday').text(),
                mw.message('dtp2-daynamesmin-saturday').text()
            ]
        }
    };
    // Run
    mw.ext.datetimepicker2.init();

})(mediaWiki, jQuery);