function submitForm() {
    var formData = new FormData(document.getElementById("coffeeForm"));

    if (!window.fetch) {
        // Use XMLHttpRequest as a fallback if fetch is not supported
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'saveData.php', true);
        xhr.onload = function() {
            handleResponse(xhr);
        };
        xhr.send(formData);
    } else {
        // Use fetch
        fetch('saveData.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
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
}

function handleResponse(xhr) {
    if (xhr.status >= 200 && xhr.status < 300) {
        alert(xhr.responseText);
        if (xhr.responseText.includes("Data saved successfully")) {
            document.getElementById("coffeeForm").reset();
        }
    } else {
        console.error("Error saving data. HTTP status code: " + xhr.status);
        alert("Error saving data. Please try again.");
    }
}
