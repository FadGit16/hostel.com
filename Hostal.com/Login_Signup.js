const signInButton = document.getElementById("signIn");
const signUpButton = document.getElementById("signUp");
const container = document.getElementById("container");
const nextButton = document.getElementById("nextButton");
const steps = document.querySelectorAll(".step");

signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

nextButton.addEventListener("click", () => {
  steps[0].classList.remove("active");
  steps[1].classList.add("active");
});