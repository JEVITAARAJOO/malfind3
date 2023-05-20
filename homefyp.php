<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Based Malware Detection Platfrom</title>

     <!-- Favicons -->
     <link href="assets/imagess/Malfindpng.png" rel="icon">

     <!-- Template Main CSS File -->
     <link href="assets/css/style.css" rel="stylesheet">
   
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">
      
    <!-- ======= navigation ======= -->
    <div id="abc">
        <nav>
            <ul>
                <li><a href="homefyp.html">Home</a></li>
                <li><a href="aboutus.html">About us</a></li>
                <li><a href="contactsus.html">Contact Us</a></li>
            </ul>
        </nav>
    <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
        <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

    <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="carousel-container">
          <h2 class="animate__animated animate__fadeInDown">Welcome to <span>MalFind</span></h2>
          <p class="animate__animated fanimate__adeInUp">This platform for detecting malware inside image before downloads.</p>
          <!-- <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a> -->
        </div>
      </div>
    </div>

    <!--animation-->
    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
      <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
      </g>
    </svg>
    
    </section><!-- End Hero -->
    </div>
    <body>
      <div class="title"></div>
      
      <script>
        function handleFileDrop(event) {
          event.preventDefault();
    
          var file = event.dataTransfer.files[0];
          var fileType = file.type;
          var fileSize = file.size;
    
          var table = document.getElementById("result-table");
    
          // Clear previous results
          while (table.rows.length > 1) {
            table.deleteRow(1);
          }
    
          // Add new row for file type
          var fileTypeRow = table.insertRow(1);
          var fileTypeCell = fileTypeRow.insertCell(0);
          var fileTypeValueCell = fileTypeRow.insertCell(1);
          fileTypeCell.textContent = "File Type";
          fileTypeValueCell.textContent = fileType;
    
          // Add new row for file size
          var fileSizeRow = table.insertRow(2);
          var fileSizeCell = fileSizeRow.insertCell(0);
          var fileSizeValueCell = fileSizeRow.insertCell(1);
          fileSizeCell.textContent = "File Size";
          fileSizeValueCell.textContent = fileSize + " bytes";
        }
    
        function preventDefaultActions(event) {
          event.preventDefault();
        }
      </script>

      <!-- <div id="drop-box"> -->
      <div id="drop-box" id="drop-box" ondragover="preventDefaultActions(event)" ondrop="handleFileDrop(event)">
      <p>Drop your file here</p>
      </div>

      <table id="result-table"style="margin: auto;">
        <tr>
          <th>Property</th>
          <th>Value</th>
        </tr>
      </table>

      <div id="result"></div>
      
      <div id="hash">
      <button id="submit-btn">Submit Hash</button>
      </div>
  
      <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
      
      <!-- include axios library using a CDN -->
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script type="module">
        const dropBox = document.getElementById('drop-box');
        const submitBtn = document.getElementById('submit-btn');
        const resultDiv = document.getElementById('result');
        var storedHash = "";
        var file = null;
        // Prevent default behavior when image is dropped
        dropBox.addEventListener('dragover', (e) => {
          e.preventDefault();
        });
  
        // Retrieve image file when dropped
        dropBox.addEventListener('drop', (e) => {
          e.preventDefault();
          file = e.dataTransfer.files[0];
          // Calculate hash value of the image file
          const reader = new FileReader();
          reader.onload = (e) => {
            const wordArray = CryptoJS.lib.WordArray.create(e.target.result);
            const hash = CryptoJS.SHA256(wordArray).toString();
            resultDiv.innerHTML = `Hash value: ${hash}`;
            storedHash = hash;
          }
          reader.readAsArrayBuffer(file);
        });
  
        // Send hash value to VirusTotal API
        submitBtn.addEventListener('click', () => {
          // SEND THE FILE FIRST
          const options1 = {
            method: 'POST',
            headers: {
              'x-apikey': '9d0b5538725f7d405561f9df4e6be379c3a0edb2db93d21032cc8c66568f5f59'
            },
            data: new FormData()
          };
          options1.data.append('file', file);
  
          const options = {
            method: 'GET',
            url: `https://www.virustotal.com/api/v3/files/${storedHash}`,
            headers: {
              accept: 'application/json',
              'x-apikey': '9d0b5538725f7d405561f9df4e6be379c3a0edb2db93d21032cc8c66568f5f59'
            }
          };
  
          axios.post('https://www.virustotal.com/api/v3/files', options1.data, options1)
            .then(response => {
              console.log(response.data);
              //resultDiv.innerHTML += `<div><br>Upload results: ${JSON.stringify(response)} </div>`;
  
              axios
                .request(options)
                .then(function (response) {
                  console.log(response.data);
                  //resultDiv.innerHTML += `<div><br>Scan results: ${JSON.stringify(response.data.data.attributes.last_analysis_stats)} </div>`;
  
                const link = `https://www.virustotal.com/gui/file/${storedHash}/detection`; //
                // Replace the window.open(link) line with the following code
              const tableDiv = document.createElement('div');
              tableDiv.innerHTML = '<table id="scan-results"><tr><th>Engine</th><th>Result</th></tr></table>';
              resultDiv.appendChild(tableDiv);

              axios
                .request(options)
                .then(function (response) {
                  console.log(response.data);

                  const analysisStats = response.data.data.attributes.last_analysis_stats;
                  const scanResultsTable = document.getElementById('scan-results');

                  for (const engine in analysisStats) {
                    const result = analysisStats[engine];
                    const row = scanResultsTable.insertRow();
                    const engineCell = row.insertCell();
                    const resultCell = row.insertCell();
                    engineCell.textContent = engine;
                    resultCell.textContent = result;
                  }
                })
                .catch(function (error) {
                  console.error(error);
                });

                })
                .catch(function (error) {
                  console.error(error);
                });
  
            })
            .catch(error => {
              console.error(error);
            });
  
        });
  
      </script>


</body>
</html>
</body>
</html>

<!-- ======= Footer ======= -->
<footer id="footer">
<div class="copyright">
&copy; Copyright <strong><span>MalFind</span></strong>. All Rights Reserved
</div>

</body>
</html>
</body>
</html>