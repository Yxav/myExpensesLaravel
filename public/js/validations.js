function validateNumberInput(element){
    let inputElementValue = document.getElementById(element).value;
    let regexPattern = /^\d+$/;
    return regexPattern.test(inputElementValue);
}

function validateForm(){
    if(!validateNumberInput("amount")){
        $("#amount").addClass("invalid");
        M.toast({html: 'O campo valor deve ser numérico!', classes: 'red'});

        return false
    }
    return true
}
