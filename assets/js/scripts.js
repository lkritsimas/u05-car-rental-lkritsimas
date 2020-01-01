// Remove vehicle
document
    .querySelectorAll('[data-target="removeVehicle"]')
    .forEach(function(buttonEl) {
        buttonEl.addEventListener("click", function() {
            // Table row for corresponding vehicle ID
            let row = event.target.parentNode.parentNode;
            let vehicleId = this.dataset.id;
            let removeVehicle = confirm(
                `Remove vehicle with id "${vehicleId}"?`
            );
            if (removeVehicle !== true) return;

            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.status !== 200) {
                    alert("Error: Something went wrong!");
                } else {
                    // Check if request was successful
                    let parsedResponse = JSON.parse(xhr.response);

                    // Remove row if so
                    if (parsedResponse.success) {
                        row.remove();
                    } else {
                        alert("Error: Something went wrong!");
                    }
                }
            };

            xhr.open("POST", `/vehicles/remove/${vehicleId}`, false);
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            xhr.send(`id=${vehicleId}`);
        });
    });

// Remove customer
document
    .querySelectorAll('[data-target="removeCustomer"]')
    .forEach(function(buttonEl) {
        buttonEl.addEventListener("click", function() {
            // Table row for corresponding vehicle ID
            let row = event.target.parentNode.parentNode;
            let customerId = this.dataset.id;
            let removeCustomer = confirm(
                `Remove customer with id "${customerId}"?`
            );
            if (removeCustomer !== true) return;

            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.status !== 200) {
                    alert("Error: Something went wrong!");
                } else {
                    // Check if request was successful
                    let parsedResponse = JSON.parse(xhr.response);

                    // Remove row if so
                    if (parsedResponse.success) {
                        row.remove();
                    } else {
                        alert("Error: Something went wrong!");
                    }
                }
            };

            xhr.open("POST", `/customers/remove/${customerId}`, false);
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
            xhr.send(`id=${customerId}`);
        });
    });
