function submitForm() {
    var formData = new FormData(document.getElementById("coffeeForm"));

    fetch('auth/saveData.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data.includes("Data saved successfully")) {
            document.getElementById("coffeeForm").reset();
        }
    })
    .catch(error => {
        console.error("Error saving data: ", error);
        alert("Error saving data. Please try again.");
    });
}
