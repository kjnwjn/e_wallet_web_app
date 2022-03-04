// handle click hide modal
loginFormHide = document.querySelector(".form-login-hide");
registerFormHide = document.querySelector(".form-register-hide");
modal = document.querySelector(".modal");
modalOverlay = document.querySelector(".modal__overlay");
function showRegisterForm() {
  if (!modal.classList.contains("form-login-hide")) {
    loginFormHide.classList.add("form-login-hide");
  }
  modal.classList.remove("modal-hide");
  registerFormHide.classList.remove("form-register-hide");
}

function showLoginForm() {
  if (!modal.classList.contains("form-register-hide")) {
    registerFormHide.classList.add("form-register-hide");
  }
  modal.classList.remove("modal-hide");
  loginFormHide.classList.remove("form-login-hide");
}

modalOverlay.onclick = function () {
  modal.classList.add("modal-hide");
};

function switchLoginForm() {
  registerFormHide.classList.add("form-register-hide");
  loginFormHide.classList.remove("form-login-hide");
}
function switchRegisterForm() {
  loginFormHide.classList.add("form-login-hide");
  registerFormHide.classList.remove("form-register-hide");
}

function postData(url = "", data = {}) {
  const response = fetch(url, {
    method: "POST",
    mode: "cors",
    cache: "no-cache",
    credentials: "same-origin",
    headers: {
      "Content-Type": "application/json",
    },
    redirect: "follow",
    referrerPolicy: "no-referrer",
    body: JSON.stringify(data),
  });
  return response;
}

$(".form-login").submit(function (e) {
  e.preventDefault();
  let url = "http://localhost/api/login";
  let email = $("#email").val();
  let password = $("#password").val();
  // console.log({email,password});
  postData(url, {
    email: email,
    password: password,
  }).then((data) => {
    console.log(data);
  });
});
