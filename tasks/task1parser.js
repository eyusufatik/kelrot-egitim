realName = "";
ppURL = "";

function parseURL() {
  var xhttp = new XMLHttpRequest();
  var parser = new DOMParser();
  var htmlDoc;
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Typical action to be performed when the document is ready:
      htmlDoc = parser.parseFromString(xhttp.responseText, "text/html");
      var isTaskDone = checkIfTaskDone(htmlDoc);
      console.log(isTaskDone);
      if (isTaskDone) {
        document.getElementById("error").textContent = "Ooo site tam da istendiği gibi olmuş çok iyi!";
        $.ajax({
          type: "POST",
          url: "task1.php",
          data: { real: realName, pp: ppURL },
          success: function (data) {
            console.log(data);
          },
        });
      }
    }
  };
  console.log(document.getElementById("link").value);
  var link = new URL(document.getElementById("link").value);
  console.log(link.href);
  xhttp.open("GET", link.href, true);
  xhttp.send();
}

function checkIfTaskDone(htmlDoc) {
  var errorText = document.getElementById("error");

  try {
    //data to be scrapped
    realName = htmlDoc.getElementsByTagName("h1")[0].innerText;
    ppURL = htmlDoc.getElementsByTagName("img")[0].src;
    ppURL =
      document.getElementById("link").value +
      ppURL.substring(ppURL.indexOf("tasks/") + 6);

    //elements to be checked
    var summarySection = htmlDoc.getElementById("summary");
    var educationSection = htmlDoc.getElementById("education");
    var skillsSection = htmlDoc.getElementById("skills");
    var contactSection = htmlDoc.getElementById("contact");

    var taskDone = true;

    if (summarySection == null || summarySection.innerText == null) {
      taskDone = false;
      errorText.textContent += "özet sectionında bi sorun var";
    }
    if (educationSection == null || educationSection.innerText == null) {
      taskDone = false;
      errorText.textContent += "\neğitim sectionında bi sorun var";
    }
    if (skillsSection == null || skillsSection.innerText == null) {
      taskDone = false;
      errorText.textContent += "\nyetenek sectionında bi sorun var";
    }
    if (contactSection == null || contactSection.innerText == null) {
      taskDone = false;
      errorText.textContent += "\niletişim sectionında bi sorun var";
    }
    return taskDone;
  } catch {
    errorText.textContent = "Bi şeyler eksik... sezebiliyorum.";
    return false;
  }

  /*console.log(summarySection.innerText);
  console.log(educationSection.innerText);
  console.log(skillsSection.innerText);
  console.log(contactSection.innerText);*/
}
