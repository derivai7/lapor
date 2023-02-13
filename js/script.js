document.forms["formLaporan"]["pengaduan"].addEventListener("click", () => {
    document.querySelector(".isComplaint").style.display = "block";
})

document.forms["formLaporan"]["aspirasi"].addEventListener("click", () => {
    document.querySelector(".isComplaint").style.display = "none";
})