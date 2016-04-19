var bridge = function (presenterPath) {
    window.rhubarb.viewBridgeClasses.HtmlViewBridge.apply(this, arguments);
};

bridge.prototype = new window.rhubarb.viewBridgeClasses.HtmlViewBridge();
bridge.prototype.constructor = bridge;

bridge.prototype.attachEvents = function () {
    window.rhubarb.viewBridgeClasses.HtmlViewBridge.prototype.attachEvents.apply(this, arguments);

    // New account / confirm details validation
    var requiredValidations = [];
    var requiredViewBridges = ["Forename", "Surname", "PhoneNumber"];

    for(var i = 0; i < requiredViewBridges.length; i++){
        var fieldValidation = new validation.validator();
        fieldValidation
            .require(requiredViewBridges[i] + " is required")
            .setSource(requiredViewBridges[i])
            .setTargetElement(requiredViewBridges[i].toLowerCase() + "-validation");

        requiredValidations.push(fieldValidation);
    }

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
        .setTargetElement("address-validation");

    requiredValidations.push(pafValidation);

    document.getElementById("create-button").addEventListener("click", function () {
        validation.common.allValid(requiredValidations)(true, function(){
            process('create', 'RegisterAndContinue');
        }, function(errorMessages){
            alert(errorMessages[0]);
        });
    });
};


window.rhubarb.viewBridgeClasses.IndexViewBridge = bridge;
