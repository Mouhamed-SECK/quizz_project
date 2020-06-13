const file = document.getElementById("file");

function preview_image(e) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("avatar");
    output.src = reader.result;
    const avatarName = document.getElementById("avatar-name");
    avatarName.innerText = prenom.value;
  };
  reader.readAsDataURL(e.target.files[0]);
}
if (file) file.addEventListener("change", preview_image);
