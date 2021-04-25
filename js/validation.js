function validateUsername(field)
{
    if (field.trim() == "") return "Username cannot be empty.\n"
    else if (field.length < 5)
        return "Usernames must be at least 5 characters.\n"
    else if (/[^a-zA-Z0-9_-]/.test(field))
        return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n"
    return ""
}

function validatePassword(field)
{
    if (field.trim() == "") return "Password cannot be empty.\n"
    else if (field.length < 6)
        return "Passwords must be at least 6 characters.\n"
    return ""
}


function validateEmail(field)
{
    if (field.trim() == "") return "Email cannot be empty.\n"
    else if (!((field.indexOf(".") > 0) &&
        (field.indexOf("@") > 0)) ||
        /[^a-zA-Z0-9.@_-]/.test(field))
        return "The Email address is invalid.\n"
    return ""
}

function validateSignUp(form){
    let fail = ""
    let allInputs = form.querySelectorAll("input")
    let username = allInputs[0].value
    let password = allInputs[1].value
    let email = allInputs[2].value


    fail += validateUsername(username);
    fail +=validatePassword(password);
    fail +=validateEmail(email);

    if(!fail.trim()){
        return true
    }else{
        alert(fail)
        return fail
    }
}

function validateLogIn(form){
    let fail = ""
    let allInputs = form.querySelectorAll("input")
    let email = allInputs[0].value
    let password = allInputs[1].value

    fail +=validatePassword(password);
    fail +=validateEmail(email);

    if(!fail.trim()){
        return true
    }else{
        alert(fail)
        return fail
    }
}