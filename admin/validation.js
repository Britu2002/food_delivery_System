 function validateForm(event) {
            let input = document.getElementById("product").value;
            let options = document.querySelectorAll("#productList option");
            
            for (let option of options) {
                if (option.value.toLowerCase() === input.toLowerCase()) {
                    alert("This product already exists. Please enter a new product.");
                    event.preventDefault(); // Form submit hone se rokenge
                    return false;
                }
            }
            return true;
        }
   