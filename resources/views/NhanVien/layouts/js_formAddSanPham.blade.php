<script src="admin/js/jquery-3.2.1.min.js"></script>
<script src="admin/js/popper.min.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/main.js"></script>
<script src="admin/js/plugins/pace.min.js"></script>
<script>
    const inpFile = document.getElementById("inpFile");
    const loadFile = document.getElementById("loadFile");
    const previewContainer = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
    inpFile.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";
            reader.addEventListener("load", function () {
                previewImage.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }
    });

</script>
