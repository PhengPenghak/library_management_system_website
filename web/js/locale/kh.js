(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('fullcalendar')) :
        typeof define === 'function' && define.amd ? define(['fullcalendar'], factory) :
            (global = global || self, factory(global.FullCalendar));
}(this, function (FullCalendar) {
    'use strict';

    FullCalendar.globalLocales.push(function () {
        'use strict';

        var kh = {
            code: "kh",
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4, // The week that contains Jan 4th is the first week of the year.
            },
            buttonText: {
                prev: "មុន",
                next: "បន្ទាប់",
                today: "ថ្ងៃនេះ",
                month: "ខែ",
                week: "សប្តាហ៍",
                day: "ថ្ងៃ",
                list: "បញ្ជី",
            },
            weekLabel: "សប្តាហ៍",
            allDayText: "ពេញមួយថ្ងៃ",
            eventLimitText: "ច្រើនទៀត",
            noEventsMessage: "គ្មានព្រឹត្តិការណ៍ត្រូវបង្ហាញ",
        };

        return kh;

    });

}));
