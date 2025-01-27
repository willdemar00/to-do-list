let areaImg = document.querySelector(".img-placeholder");
let imgInput = areaImg.querySelector("input[type='file']");

areaImg.addEventListener("click", () => {
    imgInput.click();
});

imgInput.addEventListener("change", (event) => {
    handleImageUpload(event.target.files[0]);
});

areaImg.addEventListener("dragover", (e) => {
    e.preventDefault();
    areaImg.classList.add("dragover");
});

areaImg.addEventListener("dragleave", () => {
    areaImg.classList.remove("dragover");
});

areaImg.addEventListener("drop", (e) => {
    e.preventDefault();
    areaImg.classList.remove("dragover");
    let file = e.dataTransfer.files[0];
    let dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    imgInput.files = dataTransfer.files;
    handleImageUpload(file);
});

function handleImageUpload(file) {
    if (file) {
        let reader = new FileReader();
        reader.onload = function () {
            let img = areaImg.querySelector("img");
            img.src = reader.result;
            img.style.display = "block";
        };
        if (areaImg.querySelector("span")) {
            areaImg.querySelector("span").remove();
        }
        reader.readAsDataURL(file);
    }
}
