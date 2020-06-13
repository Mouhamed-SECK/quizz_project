const numberQuestionForm = document.getElementById("question-number-form");
const numberQuestion = document.getElementById("nbreQuestion");
state = {
  valide: true,
};
function checkIsNumber(input) {
  if (isNaN(input.value)) {
    showError(input, "saisir un nombre");
    state.valide = false;
  }
}

// Get Feild Name
function getInputFeild(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Check Required feild
function checkRequired(inputArr) {
  inputArr.forEach((input) => {
    if (input.value.trim() === "") {
      showError(input, `${getInputFeild(input)} is required `);
      state.valide = false;
    }
  });
}

// show sucess
document.addEventListener("keyup", (e) => {
  e.target.parentElement.querySelector("small").innerHTML = "";
});

function showError(input, message) {
  const formControl = input.parentElement;
  const small = formControl.querySelector("small");
  small.innerText = message;
}

numberQuestionForm.addEventListener("submit", (e) => {
  state.valide = true;

  checkRequired([numberQuestion]);
  checkIsNumber(numberQuestion);

  if (state.valide == false) {
    e.preventDefault();

    return false;
  }
});
