function validateNumberInput(element){
    let inputElementValue = document.getElementById(element).value;
    let regexPattern = /^\d+$/;
    return regexPattern.test(inputElementValue);
}
