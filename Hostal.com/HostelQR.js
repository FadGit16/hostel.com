document.getElementById("hostel-form").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const statusDiv = document.getElementById("status");

  if (email.trim() === "") {
    statusDiv.textContent = "Please enter a valid User Email.";
    return;
  }

  fetch("process-entry-exit.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email: email })  
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.textContent = `User ${email} has ${data.action} the hostel.`;
    } else {
      statusDiv.textContent = `Error: ${data.message}`;
    }
  })
  .catch(error => {
    console.error('Error:', error);  
    statusDiv.textContent = "Error processing the request.";
  });
});
document.getElementById("hostel-form").addEventListener("submit", function(e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const statusDiv = document.getElementById("status");

  if (email.trim() === "") {
    statusDiv.textContent = "Please enter a valid User Email.";
    return;
  }

  fetch("process-entry-exit.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email: email })  
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.textContent = `User ${email} has ${data.action} the hostel.`;
    } else {
      statusDiv.textContent = `Error: ${data.message}`;
    }
  })
  .catch(error => {
    console.error('Error:', error);  
    statusDiv.textContent = "Error processing the request.";
  });
});
