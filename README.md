# nosey notifications

This Moodle plugin lets you snoop on certain events and post the record and event data to an external url, using BODY formatted JSON sent via a custom POST. (Internally it uses cURL).

You would normally capture this data in php using something like `$data = json_decode(file_get_contents(“php://input”));` - or whatever your languages equivalent is for capturing the whole request body.

It currently captures the following events:
* User enrols in a course
* User unenrols from a course
* Activity completes within a course
* Course completes
* Course record is created, updated or deleted
* Category record is created, updated or deleted

But coders should be able to extend the same system for any of the events listed [here](https://docs.moodle.org/dev/Event_2) - or any of your own custom events, of course.

## installation

This belongs in your moodle's `~/local/nosey/` (where `~` is the moodle root - the same folder that has `config.php` in it).

## configuration

You can configure the plugin by going (as admin) to Site Administration > Plugins > Local Plugins > Nosey Notifications. The screen shows you things like the URL - each different event can have its own URL. If your plugin also has certificates (pem format) in ~/local/nosey/certificate/ folder then they can be selected for SSL. And there’s a global “on/off” toggle for all events.

## example data

Here’s a dump of a typical request body (I've captured this using [RequestBin](http://requestb.in) and formatted the json using [js beautifier](http://jsbeautifier.org)).

    {
        "event": {
            "eventname": "\\core\\event\\course_updated",
            "component": "core",
            "action": "updated",
            "target": "course",
            "objecttable": "course",
            "objectid": 41,
            "crud": "u",
            "edulevel": 1,
            "contextid": 576,
            "contextlevel": 50,
            "contextinstanceid": 41,
            "userid": 8,
            "courseid": 41,
            "relateduserid": null,
            "anonymous": 0,
            "other": {
                "shortname": "CPR",
                "fullname": "Cardiopulmonary Resuscitation"
            },
            "timecreated": 1462786276
        },
        "record": {
            "id": 41,
            "category": 1,
            "sortorder": 10005,
            "fullname": "Cardiopulmonary Resuscitation",
            "shortname": "CPR",
            "idnumber": "",
            "summary": "<div style=\"float: right; width: 130px; text-align: center;\"><img src=\"@@PLUGINFILE@@\/1_CPR%20%281%29.png\"><\/div>\r\n<p>Management of cardiac arrest is a critical skill for all health professionals. Regular updates are essential for maintaining the knowledge and practical skills required for CPR. The course is based on the current Australian Resuscitation Council recommendations for cardiac arrest. Topics covered in the course include : diagnosis of cardiac arrest, algorithm for basic life support, airway management, assisted ventilation and cardiac compressions, recognition of cardiac arrest rhythms, algorithm for providing advanced life support, indications and procedure for defibrillation and administration of drugs in cardiac arrest, post resuscitation care, recognition and treatment of foreign body&nbsp;airway obstruction and basic and advanced CPR in the child.<\/p>\r\n<p><strong>Information about the Course<\/strong><\/p>\r\n<ul>\r\n<li>Designed for medical officers, nurses, paramedics and students in all medical fields<\/li>\r\n<li>CME hours : Certified for 8.5 hours of continuing medical education<\/li>\r\n<li>CPD accreditation : RACGP, ACRRM<\/li>\r\n<li>Duration of enrolment : 12 months (commences from the date of course enrolment)<\/li>\r\n<li>CPD Certificate is provided with successful completion of the course<\/li>\r\n<\/ul>\r\n<p><\/p>",
            "summaryformat": 1,
            "format": "grid",
            "showgrades": 1,
            "newsitems": 5,
            "startdate": 1388494800,
            "marker": 10,
            "maxbytes": 50331648,
            "legacyfiles": 2,
            "showreports": 1,
            "visible": 1,
            "visibleold": 1,
            "groupmode": 1,
            "groupmodeforce": 1,
            "defaultgroupingid": 0,
            "lang": "",
            "theme": "",
            "timecreated": 1266877154,
            "timemodified": 1462786276,
            "requested": 0,
            "enablecompletion": 1,
            "completionnotify": 0,
            "cacherev": 1462786276,
            "calendartype": ""
        }
    }

here’s a category update - which happens every time someone is editing a category and presses “update”.

    {
        "event": {
            "eventname": "\\core\\event\\course_category_updated",
            "component": "core",
            "action": "updated",
            "target": "course_category",
            "objecttable": "course_categories",
            "objectid": 20,
            "crud": "u",
            "edulevel": 0,
            "contextid": 1384,
            "contextlevel": 40,
            "contextinstanceid": 20,
            "userid": 8,
            "courseid": 0,
            "relateduserid": null,
            "anonymous": 0,
            "other": null,
            "timecreated": 1462794641
        },
        "record": {
            "id": 20,
            "name": "Spoopy!",
            "idnumber": "r2d2",
            "description": "<p>bleep bloop<\/p>",
            "descriptionformat": 1,
            "parent": 0,
            "sortorder": 160000,
            "coursecount": 0,
            "visible": 1,
            "visibleold": 1,
            "timemodified": 1462794641,
            "depth": 1,
            "path": "\/20",
            "theme": null
        }
    }

here’s the same record when it is deleted. you can see record is false since the record is now deleted, but event.objectid has the row of the record that was deleted.

    {
        "event": {
            "eventname": "\\core\\event\\course_category_deleted",
            "component": "core",
            "action": "deleted",
            "target": "course_category",
            "objecttable": "course_categories",
            "objectid": 20,
            "crud": "d",
            "edulevel": 0,
            "contextid": 1384,
            "contextlevel": 40,
            "contextinstanceid": 20,
            "userid": 8,
            "courseid": 0,
            "relateduserid": null,
            "anonymous": 0,
            "other": {
                "name": "Slorp!"
            },
            "timecreated": 1462794769
        },
        "record": false
    }

## License:

http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later