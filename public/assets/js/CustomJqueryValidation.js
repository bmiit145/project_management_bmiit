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
