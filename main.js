// handle click hide modal
// loginFormHide = document.querySelector(".form-login-hide");
// registerFormHide = document.querySelector(".form-register-hide");
// modal = document.querySelector(".modal");
// modalOverlay = document.querySelector(".modal__overlay");
// function showRegisterForm() {
//   if (!modal.classList.contains("form-login-hide")) {
//     loginFormHide.classList.add("form-login-hide");
//   }
//   modal.classList.remove("modal-hide");
//   registerFormHide.classList.remove("form-register-hide");
// }

// function showLoginForm() {
//   if (!modal.classList.contains("form-register-hide")) {
//     registerFormHide.classList.add("form-register-hide");
//   }
//   modal.classList.remove("modal-hide");
//   loginFormHide.classList.remove("form-login-hide");
// }

// modalOverlay.onclick = function () {
//   modal.classList.add("modal-hide");
// };

// function switchLoginForm() {
//   registerFormHide.classList.add("form-register-hide");
//   loginFormHide.classList.remove("form-login-hide");
// }
// function switchRegisterForm() {
//   loginFormHide.classList.add("form-login-hide");
//   registerFormHide.classList.remove("form-register-hide");
// }

// function postData(url = "", data = {}) {
//   const response = fetch(url, {
//     method: "POST",
//     mode: "cors",
//     cache: "no-cache",
//     credentials: "same-origin",
//     headers: {
//       "Content-Type": "application/json",
//     },
//     redirect: "follow",
//     referrerPolicy: "no-referrer",
//     body: JSON.stringify(data),
//   });
//   return response;
// }

// $(".form-login").submit(function (e) {
  //   e.preventDefault();
  //   let url = "http://localhost/api/login";
  //   let email = $("#email").val();
  //   let password = $("#password").val();
  //   // console.log({email,password});
  //   postData(url, {
    //     email: email,
    //     password: password,
    //   }).then((data) => {
      //     console.log(data);
      //   });
      // });
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
      return value ? undefined : "This field can not be empty";
    },
    email: function (value) {
      var regex =
        /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
      return regex.test(value) ? undefined : "Email is not valid";
    },
    min: function (min) {
      return function (value) {
        return (value.length = min
          ? undefined
          : `This field must be ${min} characters`);
      };
    },
    // max: function (max) {
    //   return function (value) {
    //     return value.length <= max
    //       ? undefined
    //       : `This field must be ${max} characters`;
    //   };
    // },
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
      var inputValue = e.target.value;
      var errorMessage;
      var parent;
      var error;
      for (rule of rules) {
        errorMessage = rule(inputValue);
        if (errorMessage) break;
      }
      if (errorMessage) {
        var parent = getParent(event.target, ".form-validation");
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
          var btnDisable = issetForm.querySelector(".btn");

          // Return form values
          var formInputs = issetForm.querySelectorAll("[name]");
          var formValues = Array.from(formInputs).reduce(function (
            values,
            input
          ) {
            return (values[input.name] = input.value) && values;
          },
          {});
          // Return form values

          var data = {
            btnDisable: function () {
              issetForm.querySelector(".btn").classList.add("disabled");
            },
            btnEnable: function () {
              issetForm.querySelector(".btn").classList.remove("disabled");
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
      
// Validation('#Login', {
//   onSubmit: function(e) {
//       e.btnDisable();
//       var data = e.formValues()
//       var url = 'http://localhost/api/login'
//       $.ajax({
//           url,
//           method: 'POST',
//           data: data
//       }).done(response => {
//           console.log(response);
//           if (!response.status) {
//               if (response.abnormal === 1) {
//                   toastr.error(response.msg);
//               } else {
//                   toastr.error(response.msg);
//               }
//           } else {
//               toastr.success(response.msg)
//               window.location.href = response.redirect;
//           }
//       });
//   }
// })
