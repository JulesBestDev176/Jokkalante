const executeAnimation = (label) => {
  label.innerHTML = label.innerText
    .split("")
    .map(
      (letter, idx) =>
        `<span style="transition-delay:${idx * 50}ms">${letter}</span>`
    )
    .join("");
};

const inputs = document.querySelectorAll(".form-control input");

inputs.forEach((input) => {
  input.addEventListener("focus", () => {
    const label = input.parentNode.querySelector("label");
    executeAnimation(label);
  });

  input.addEventListener("blur", () => {
    const label = input.parentNode.querySelector("label");
    if (input.value === "") {
      label.innerHTML = label.innerText;
    }
  });
});
