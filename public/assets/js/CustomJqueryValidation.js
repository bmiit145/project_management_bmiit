$.validator.addMethod("notEqualValue", function(value, element, param) {
    return param !== value;
}, "Please select value")


$.validator.addMethod("uniqueValues", function(value, element, className) {
    var values = [];
    var isValid = true;

    // Select dropdowns by class name passed as an argument
    $('select.' + className).each(function() {
        var selectedValue = $(this).val();
        if (selectedValue !== '' && selectedValue !== '-1') {
            if (values.indexOf(selectedValue) !== -1) {
                isValid = false;
                return false; // Break out of each loop
            } else {
                values.push(selectedValue);
            }
        }
    });

    return isValid;
}, "Each dropdown value must be unique.");

$.validator.addMethod("require_from_group", function(value, element, options) {
    var fields = $(options[1], element.form);
    var filledFields = fields.filter(function() {
        return $(this).val() !== '-1';
    });
    return filledFields.length >= options[0];
} , "Please fill at least one of these fields.");


$.validator.addMethod("validDateTime", function(value, element) {
    // Define your desired date and time format using Regular Expression
    // Here, it's YYYY-MM-DD HH:MM (24-hour format)
    return this.optional(element) || /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/.test(value);
}, "Please enter a valid date and time in the format YYYY-MM-DD HH:MM");

$.validator.addMethod("pattern", function(value, element, pattern) {
    return this.optional(element) || new RegExp(pattern).test(value);
}, "Invalid format.");


