{
  /* HOW TO USE:

    1. In HTML file, make sure that your form input correct with this format:
    =====================================================================================================
    =    <div class="form-validation">                                                                  =
    =       <input type="email" name="email" id="email" class="form-control" rules="required&email">    =
    =       <label for="email">Your email address</label>                                               =
    =       <span class="error-message"></span>                                                         =
    =    </div>                                                                                         =
    =====================================================================================================


    2. In Javascript file, call this function with param is your form ID:
    =====================================================================================================
    =      Validation("#login-form", {                                                                  =
    =          onSubmit: function (a) {                                                                 =
    =            a.btnDisable();                                                                        =
    =            $.ajax({                                                                               =
    =                async: true,                                                                       =
    =                type: "post",                                                                      =
    =                data: {[YOUR BODY DATA HERE]},                                                     =
    =                url: "YOUR API URL",                                                               =
    =                success: function (response) {                                                     =
    =                    a.btnEnable();                                                                 =
    =                },                                                                                 =
    =            });                                                                                    =
    =          },                                                                                       =
    =      });                                                                                          =
    =====================================================================================================
*/
}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>;

function Validation(formSelector, options) {
  if (!options) {
    var options = {};
  }

  function getParent(element, selector) {
    while (element.parentElement) {
      if (element.parentElement.matches(selector)) {
        return element.parentElement;
      }
      element = element.parentElement;
    }
  }

  var issetForm = document.querySelector(formSelector);
  var submitButton = issetForm.getElementsByTagName("Button");
  var formRules = {};
  var validationRules = {
    required: function (value) {
      return value.trim() ? undefined : "This field can not be empty";
    },
    email: function (value) {
      var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
      return regex.test(value) ? undefined : "Email is not valid";
    },
    min: function (min) {
      return function (value) {
        return value.length >= min ? undefined : `This field must be at least ${min} characters`;
      };
    },
  };

  if (issetForm) {
    var inputs = issetForm.querySelectorAll("[name][rules]");
    for (var input of inputs) {
      var inputRules = input.getAttribute("rules").split("&");
      for (var rule of inputRules) {
        var ruleInfo;
        var rulseHasValue = rule.includes("=");
        if (rulseHasValue) {
          ruleInfo = rule.split("=");
          rule = ruleInfo[0];
        }
        var ruleFunction = validationRules[rule];
        if (rulseHasValue) {
          ruleFunction = ruleFunction(ruleInfo[1]);
        }
        if (Array.isArray(formRules[input.name])) {
          formRules[input.name].push(ruleFunction);
        } else {
          formRules[input.name] = [ruleFunction];
        }
      }
      input.onblur = handleValidate;
      input.oninput = handleClearError;
      issetForm.querySelector(".btn").classList.add("disabled");
    }

    inputs[inputs.length - 1].addEventListener("input", (e) => {
      issetForm.querySelector(".btn").classList.remove("disabled");
    });

    function handleValidate(e) {
      var rules = formRules[e.target.name];
      var inputValue = e.target.value.trim();
      var errorMessage;
      var parent;
      var error;
      for (rule of rules) {
        errorMessage = rule(inputValue);
        if (errorMessage) break;
      }
      if (errorMessage) {
        var parent = getParent(e.target, ".form-validation");
        if (parent) {
          var errorBox = parent.querySelector(".error-message");
          if (errorBox) {
            errorBox.innerText = errorMessage;
          }
          parent.classList.add("invalid");
        }
      }
      return !errorMessage;
    }

    function handleClearError(e) {
      var input = e.target;
      var parent = getParent(input, ".form-validation");
      var errorBox = parent.querySelector(".error-message");
      parent.classList.remove("invalid");
      errorBox.innerText = "";
    }

    issetForm.addEventListener("submit", (e) => {
      e.preventDefault();
      var isValid = true;
      var inputs = issetForm.querySelectorAll("[name][rules]");
      for (var input of inputs) {
        if (!handleValidate({ target: input })) {
          isValid = false;
        }
      }
      if (isValid) {
        if (typeof options.onSubmit == "function") {
          var btnOriginInnerText = issetForm.querySelector(".btn").innerText;

          // Return form values
          var formInputs = issetForm.querySelectorAll("[name]");
          var formValues = Array.from(formInputs).reduce(function (values, input) {
            return (values[input.name] = input.value) && values;
          }, {});
          // Return form values

          var data = {
            btnDisable: function () {
              issetForm.querySelector(".btn").classList.add("disabled");
              issetForm.querySelector(".btn").classList.add("loading");
              issetForm.querySelector(".btn").innerText = "Loading...";
            },
            btnEnable: function () {
              issetForm.querySelector(".btn").classList.remove("disabled");
              issetForm.querySelector(".btn").classList.remove("loading");
              issetForm.querySelector(".btn").innerText = btnOriginInnerText;
            },
            formValues: function () {
              return formValues;
            },
          };
          options.onSubmit(data);
        } else {
          issetForm.submit();
        }
      }
    });
  }
}
