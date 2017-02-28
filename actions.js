
/*
* This function updates the hidden value of a field
* in the checkout page. By changing the value, we then
* check for it on the server and then decide if we have to 
* update the details for the user
*  
*/
function updateAddress()
{
	document.getElementById("update").value=1;
}

/*
* This function can swap the requirement fields in any form. By padding in the entire
* form, the requirement option will change for all the fields, or passing in the 
* fieldset will only change the requirement of elements in that fieldset.
* 
* >>>>>>>This method of swapping the requirement of the CC details was buggy<<<<<<<<
* 
*/
function swapRequirement(fields)
{
	for(var i=0;i<fields.length;i++)
	{
		var status = fields[i].required;
		fields[i].required = !status;
	}
}

/*
* This function makes the credit card fields NOT required for form submission
* 
* @param fields: The fields that are required for the credit card.
*/
function makeCCFieldsUnrequired(fields)
{
	for(var i=0;i<fields.length;i++)
	{
		fields[i].required = false;
	}
}

/*
* This function makes the credit card fields required for form submission
* 
* @param fields: The fields that are required for the credit card.
*/
function makeCCFieldsRequired(fields)
{
	for(var i=0;i<fields.length;i++)
	{
		fields[i].required = true;
	}	
}

/*
* This function is used the payment section of the checkout.php page.
* We take in value and then depending on the value given we set the 
* field to disabled and display to none of the payment option selected.
* We also call the method to swap over the required field of the unselected 
* payment option.
* 
* @param option : the payment option that is selected
*/
function swapPaymentOption (option)
{
	var fieldset = document.getElementById("creditcard");
	var ccFields = document.getElementsByClassName("cc");
	if (option.value==1)
	{
		fieldset.style.display="none";
		fieldset.disabled = true;
		makeCCFieldsUnrequired(ccFields);
		document.getElementById("paypal").style.display="block";
	}
	else
	{
		fieldset.style.display="block";
		fieldset.disabled = false;
		makeCCFieldsRequired(ccFields);
		document.getElementById("paypal").style.display="none";
	}
}

/*
* This function check to see if the new password entered by the user is the same
* as the confirm new password. Only if the passwords match will the form be sent to
* the server.
* 
* @return If the passwords match or not.
*/
function confirmPasswords ()
{
	var password = document.getElementById("newpassword").value;
	var confirmPassword = document.getElementById("confirmnewpassword").value;

	if(password==confirmPassword)
		return true;
	return false;
}

/*
* This function sets the disabled field of the submit button(update)
* to false in the profil.php page. This is called when the user makes a 
* change to their shipping address from the profile page.
*/
function activateButton ()
{
	document.getElementById("update").disabled=false;
}

/*
* This function is created to display an alert to ask the user,
* if they are sure to that they want to complete any particular action.
*/
function areYouSure(message) {
	return confirm(message);
}

/*
* This function is used in the navigation bar that appears in all pages of the
* website. It is used to toggle between what the user can see. If the menuOPtions
* are invisible it sets it to visible and sets the page_content to none, this is 
* reversed when pressed again. This is only available in the mobile view.
*/
function toggleMenu()
{

	var menuOptions = document.getElementById("menu_options");
	var pageContent = document.getElementById("page_content");
	
	if(menuOptions.style.display == "none" ||menuOptions.style.display == "" )
	{
		menuOptions.style.display = "block";
		pageContent.style.display = "none";
	}
	else
	{
		menuOptions.style.display = "none";
		pageContent.style.display = "block";
	}
}

/*
* This function check the validity of the checkout page before
* doing a postback to the server. To do this we first check if all
* the required fields are filled out and then we check if there are 
* any changes to the shipping details of the user.
* 
* #return if the form is valid for processing.
*/
function verifyCheckout()
{
	if(goThroughRequiredInputs("checkout"))
		return checkProfilePage("checkout");
	else
		return false;
}

/*
* This function was created purely for testing purposes.
*/
function debug(message)
{
	var DEBUG_MODE = true;
	if(DEBUG_MODE)
	{
		console.log(message);
	}
}

/*
* This function tests to seee if the form for registering a user had 
* been completed proplerly. We first chekc if all the required fields
* have been filled out and then check the specific requirements for each
* of the required fields.
* 
* @return If the form has been filled properly or not.
*/
function checkRegister()
{
	var isFormValid = false;
	if(goThroughRequiredInputs("register"))
		isFormValid = validateRegisterElements("register");
	else
		alert("Please fill all required elements as indicated");
	
	return isFormValid;
}

/*
* This function checks to see if the the form in the add category page has been filled out
* correctly. We again check if the name of the category if filled in correctly.
* 
* @return If the form had been filled in correctly.
*/
function checkAddCategory()
{
	
	var isFormValid = false;
	if(goThroughRequiredInputs("newcategory"))
	{
		//var myform = document.getElementById("newcategory");
		var name  = document.getElementById("category").value;
		isFormValid = isNameValid(name,"Category name can only contain Letters hyphens and apostrophy.");
	}
	else
		alert("Please fill all required elements as indicated");
	return isFormValid;
}


/*
* This function checks to see if the login page has been filled in and
* ready for authntication.
* 
* @return If the form is valid or not.
*/
function checkLogin()
{
	return goThroughRequiredInputs("login");
}

/*
* This function checks to see if the form in the add product page
* is valid or not.
* 
* @return If the form is valid or not.
*/
function checkAddProduct () 
{
	var isFormValid = false;
	if(goThroughRequiredInputs("newproduct"))
		isFormValid = validateAddProductElements("newproduct");
	else
		alert("Please fill all required elements as indicated");
	return isFormValid;
}

/*
* This function goes thorough the fields in the add products page
* and checks for field specific validation in the form. We also provide
* alerts to the user if anything is not valid.
* 
* @return If the form is valid or not.
*/
function validateAddProductElements (formName)
{
	var myform = document.getElementById(formName);

	var name = myform.pname.value;
	if(!isNameValid(name,"Name can only be A-Z, a-z, hyphen and apostrophy"))
	{
		myform.pname.focus();
		myform.pname.select();
		return false;
	}
	
	var price = myform.price.value;
	if(isNaN(price))
	{
		alert("Price must be a number");
		myform.price.focus();
		myform.price.select();
		return false;
	}

	var count = myform.inventory.value;
	if(isNaN(count)||count%1!=0)
	{
		alert("The Stock count must be a whole number");
		myform.inventory.focus();
		myform.inventory.select();
		return false;
	}
	return true;
}

/*
* This form is used to check for field specific requirment for the register
* user form in the register.php page. Alerts are provided to user to make
* any necessary changes.
* 
* @return If the form is valid
*/
function validateRegisterElements(formName)
{
	var isFormValid=true;
	var maxIdLength = 8;
	var maxPincodeLength = 4;
	var contactNumber;
	var myform = document.getElementById(formName);

	//Validating the First name
	var firstName = myform.fname.value;
	if(!isNameValid(firstName,"Name can only be A-Z, a-z, hyphen and apostrophy"))
	{
		myform.fname.focus();
		myform.fname.select();
		return false;
	}

	//Validating the last name
	var lastName = myform.lname.value;
	if(!isNameValid(lastName,"Name can only be A-Z, a-z, hyphen and apostrophy"))
	{
		myform.lname.focus();
		myform.lname.select();
		return false;
	}

	if(!validateEmail(myform.email.value))
	{
		myform.email.focus();
		myform.email.select();
		return false;
	}

	if(!validatePassword(myform.password.value,"Password start with a letter, can only have letter numbers and underscore."))
	{
		myform.password.focus();
		myform.password.select();
		return false;
	}

	//Validate the length of the postcode
	if(!validatePostcode(myform.postcode.value))
	{
		myform.postcode.focus();
		myform.postcode.select();
		return false;
	}


	
	return isFormValid;
}

/*
* This function checks to make sure that the quantity of any product
* added to the cart is more than zero
* 
* @return IF the quantity is more than zero or not.
*/
function quantityCheck(quantity)
{
	if(quantity.qty.value<=0)
	{
		alert("Quantity must be greater than 0");
		return false;
	}
	return true;
}

/*
* This function is called in the changepasswords.php page and checks if all the fields
* have been filled and that the passwords match before sending the new password to the server
* 
* @return If the form is valid or not.
*/
function checkChangePassword()
{
	if(goThroughRequiredInputs("changepasswords"))
		return confirmPasswords();
	else
		return false;
}

/*
* This function is called from the profile.php page and checks if the postcose
* provided by the user is the correct one.
* 
* @return If the postcode is valid
*/
function checkProfilePage(formName)
{
	var myform = document.getElementById(formName);
	var postcode = myform.postcode.value;
	var isFormValid = true;

	isFormValid = validatePostcode(postcode);
	return isFormValid;

}

/*
* This method checks to see if the details on the profile page re filled
* in before sending it to the server to get updated.
* 
* @return If the data provided on the data page is correct
*/
function checkProfile()
{
	if(goThroughRequiredInputs("updateAddress"))
		return checkProfilePage("updateAddress");
	else
		return false;
}

/*
* This function goes through all the required fields in any any form
* and checks to see that they are all filled in with data.
* 
* @param formName: The name of the form that needs to be checked.
* @return If the form has been filled.
*/
function goThroughRequiredInputs(formName)
{
	var myForm = document.getElementById(formName);
	var isFormFilled = true;
	var value;
	for (var i = 0; i < myForm.length; i++)
	{
		if(myForm[i].attributes["required"])
		{
			value =myForm[i].value; 
			var name = myForm[i].name;
			//If empty activate the error codes.
			if(value == "")
			{
				if(myForm[i].nextElementSibling!=null)//Avoiding potential exceptions
					myForm[i].nextElementSibling.style.display = "inline-block";
				else
					myForm[i].parentElement.nextElementSibling.style.display = "inline-block";
				isFormFilled = false;
			}
			else
			{
				if (myForm[i].nextElementSibling!=null)//Avoiding potential exceptions
					myForm[i].nextElementSibling.style.display = "none";
				else
					myForm[i].parentElement.nextElementSibling.style.display = "none";
			}
		}
	}

	debug("isFormFilled= " + isFormFilled);

	return isFormFilled;	
};

/**
 * This function checks to see if a given name is valid. The regex used
 * here check for upper and lower case alphabets and ' and - .
 *
 * @param {memberName} The name to be tested
 */
function isNameValid(memberName,alertMessage)
{
	var valid=true;
	var validationTest = /^[A-Za-z-\'\s]+$/;
	if(!validationTest.test(memberName)){

		valid = false;
		alert(alertMessage);
	}
	debug(valid);
	return valid;
}

/**
 * This function checks and email address for basic validation.
 * The regex code provide was found at http://tinyurl.com/35646w3  http://preview.tinyurl.com/35646w3
 * @return If the email address is valid or not
 */
function validateEmail(email)
{
	var isValid = true;
	var emailTest = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(!emailTest.test(email))
	{
		alert("Email is not valid");
		return false;
	} 
	return isValid;//email is valid
}

/*
* This function checks to see if the postcode provided is correct
* by making sure that it is four digits long and that it is a number.
* 
* @return If the postcode is valid.
*/
function validatePostcode(postcode)
{
	if (postcode.length!=4 || isNaN(postcode))
	{
		alert("Postcode must be a number with 4 digits.");
		return false;
	}
	return true;
}

/*
* This function checks to make sure that two passwords that the user enters
* when changing their password are the same. If it is not an alert message
* is displyed to the user.
* 
* @return If the passwords match or not.
*/
function validatePassword(password,alertMessage)
{
	var passwordTest = /^[a-zA-Z]\w{3,14}$/;
	if(!passwordTest.test(password))
    {
        isValid = false;
        alert(alertMessage);
        return false;
    }
    return true;
}