$.validator.addMethod("notEqualValue", function(value, element, param) {
    return param !== value;
}, "Please select value")
