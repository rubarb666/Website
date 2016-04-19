var bridge = function (presenterPath) {
    window.rhubarb.viewBridgeClasses.HtmlViewBridge.apply(this, arguments);
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.HtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function () {
    window.rhubarb.viewBridgeClasses.HtmlViewBridge.prototype.attachEvents.apply(this, arguments);

    // New account / confirm details validation
    var requiredValidations = [];
    var requiredViewBridges = ["Email", "Forename", "Surname", "PhoneNumber"];

    for(var i = 0; i < requiredViewBridges.length; i++){
        var fieldValidation = new validation.validator();
        fieldValidation
            .require(requiredViewBridges[i] + " is required")
            .setSource(requiredViewBridges[i])
            .addTrigger(requiredViewBridges[i])
            .setTargetElement(requiredViewBridges[i].toLowerCase() + "-validation");

        requiredValidations.push(fieldValidation);
    }

    requiredValidations[0].check(validation.common.isEmailAddress());

    var pafValidation = new validation.validator();
    pafValidation
        .require("You must enter an address")
        .setSource(function(){
            if (document.getElementById("AddressLine1").value.trim() != "" &&
                document.getElementById("Town").value.trim() != "" &&
                document.getElementById("Postcode").value.trim() != ""){

                // If all three of the fields are entered we return a positive value to make sure
                // the required validation passes.
                return "has-address";
            }

            return false;
        })
        .addTrigger("AddressLine1")
        .addTrigger("Town")
        .addTrigger("Postcode")
        .setTargetElement("address-validation");

    requiredValidations.push(pafValidation);

    var passwordValidation = new validation.validator();
    passwordValidation
        .require()
        .check(validation.common.matches(function(){ return document.getElementById("ConfirmPassword").value; }))
        .setSource('Password')
        .addTrigger('Password')
        .addTrigger('ConfirmPassword')
        .setTargetElement("password-validation");

    requiredValidations.push(passwordValidation);

    var formValidation = new validation.validator();
    formValidation
        .check(validation.common.allValid(requiredValidations))
        .setTargetElement("overall-form")
        .setMessageFormatter(function(errors)
        {
            var response = "";
            errors.map(function(item){response += "<li>" + item + "</li>"; });
            return "<ul>" + response + "</ul>";
        });

    document.getElementById("create-button").addEventListener("click", function () {
        formValidation.validate(function(){
            process('create', 'RegisterAndContinue');
        });
    });
};


window.rhubarb.viewBridgeClasses.IndexViewBridge = bridge;
