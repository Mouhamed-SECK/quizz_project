const addResponse = document.getElementById("addResponse");
const deleteResponseBtn = document.getElementById("delete-response");
const typeResponseElt = document.getElementById("typeReponse");
const responseContainer = document.getElementById("response-container");
// Form
const questionForm = document.getElementById("question-create");
const libelleQuestion = document.getElementById("libelleQuestion");
const nbrePoint = document.getElementById("nbrePoint");
const commonError = document.getElementById("common-error");

state = {
  idCurrentResponse: 1,
  typeResponse: "choixMultiple",
  valide: true,
};

const responseCompCreate = (id, type) => {
  if (type) {
    return `   
    <label for="response${id}"
        class="col-sm-3 col-form-label font-weight-bold">Reponse ${id}
        </label>
    <div class="col-sm-5">
        <input type="text" name="response-${id}" class="form-control response"
            id="response${id}">
    </div>
  
    <div class="custom-control custom-${type} py-1">
        <input type="${type}" value="true" name="isCorrect-${id}" class="custom-control-input p-2 " id="response-${id}">
        <label class="custom-control-label" for="response-${id}">
        </label>
    </div>
  
    <div class="col-sm-1 p-0">
        <img src="http://localhost/quizzP/img/ic-supprimer.png
      " id="delete-response" alt="">
    </div>
    <small class="text-danger position-absolute" style="top: 5px; left:435px"; ></small>

  `;
  }
  return `   
  <label for="response"
      class="col-sm-3 col-form-label font-weight-bold">Reponse  </label>
  <div class="col-sm-5">
      <input type="text" name="response" class="form-control response"
          id="response">
  </div>
  <small class="text-danger position-absolute" style="top: 5px; left:500px"; ></small>
  
  `;
};

const getTypeResponse = () => {
  return typeResponseElt.options[typeResponseElt.selectedIndex].value;
};

const setIdCurrentResponse = (inc) => {
  if (inc) {
    state["idCurrentResponse"] += 1;
  } else {
    state["idCurrentResponse"] += -1;
  }
};

const createResponse = ({ idCurrentResponse, typeResponse }) => {
  let response;

  switch (typeResponse) {
    case "choixMultiple":
      response = responseCompCreate(idCurrentResponse, "checkbox");
      break;

    case "choixSimple":
      response = responseCompCreate(idCurrentResponse, "radio");
      break;

    default:
      response = responseCompCreate();
  }

  const divElt = document.createElement("div");
  divElt.className += "form-group responseInput row position-relative";
  divElt.innerHTML = response;

  responseContainer.appendChild(divElt);
  setIdCurrentResponse("inc");
};

// Clean Response

typeResponseElt.addEventListener("change", (e) => {
  responseContainer.innerHTML = "";
  state.idCurrentResponse = 1;
  state.typeResponse = getTypeResponse();

  if (state.typeResponse == "choixText") {
    createResponse(state);
    addResponse.innerHTML = "";
  } else {
    addResponse.innerHTML = ` <img src="http://localhost/quizzP/img/ic-ajout-réponse.png
    "id="delete-response" alt="" >`;
  }
});

const deleteResponse = (e) => {
  if (e.target.id == "delete-response") {
    totalNode = document.querySelectorAll(".responseInput").length - 1;
    console.log(totalNode);
    state.idCurrentResponse = 1;
    responseContainer.innerHTML = "";

    for (let i = 0; i < totalNode; i++) {
      createResponse(state);
    }
  }
};

// add Response
addResponse.addEventListener("click", () => {
  commonError.innerText = "";
  if (state.idCurrentResponse <= 5) {
    createResponse(state);
  }
});

responseContainer.addEventListener("click", deleteResponse);

// validation
// Show outline error

function showError(input, message) {
  const formControl = input.parentElement.parentElement;
  const small = formControl.querySelector("small");
  small.innerText = message;
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

function checkIsNumber(input) {
  if (isNaN(input.value)) {
    showError(input, "saisir un nombre");
    return false;
  }
}

function checkResponse() {
  if (document.getElementsByClassName("responseInput").length == 0) {
    state.valide = false;
    commonError.innerText = "Veuillez ajouter au moins une réponse";
    return;
  }
  const type = getTypeResponse() == "choixMultiple" ? "checkbox" : "radio";
  const inputs = document.querySelectorAll(`input[type=${type}]`);

  console.log(inputs);

  let isChecked = false;

  for (const input of inputs) {
    if (input.checked == true) {
      console.log(input);
      isChecked = true;
      break;
    }
  }
  if (isChecked == false) {
    commonError.innerText = "Cocher une bonne réponse";
    setTimeout(() => {
      commonError.innerText = "";
    }, 3000);
    state.valide = false;
  }
}
// show sucess
document.addEventListener("keyup", (e) => {
  e.target.parentElement.parentElement.querySelector("small").innerHTML = "";
});

questionForm.addEventListener("submit", (e) => {
  state.valide = true;
  checkIsNumber(nbrePoint);

  const responses = document.querySelectorAll(".response");
  if (responses) {
    checkRequired([...responses, nbrePoint, libelleQuestion]);
  } else {
    checkRequired([nbrePoint, libelleQuestion]);
  }

  checkResponse();
  if (state.valide == false) {
    e.preventDefault();

    return false;
  }
});
