<?php 
// This page is loaded first and dfeatures just general information before login


// Header used only has two links - home(this page) and login form
include('includes/header.html');
?>

<style>
* {
  box-sizing: border-box;
}

/* Style the body */
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

/* Header/logo Title */
.header {
  padding: 80px;
  text-align: center;
  background: black;/* added an image instead of solid colour */
  color: white;
  height: 366px;/* added to make deeper */
}

.headerbackground {
    background-image: url('BMServ.png');
    background-repeat: no-repeat; /* Do not repeat the image */
    background-position: center; /* Center the image */
    background-size: contain; /* Resize the background image to cover the entire container */
}

/* Increase the font size of the heading */
.header h1 {
  font-size: 60px;
  color: white;
  
}

.header p {
  font-size: 40px;
  color: white;
  
}

.header p2 {
  font-size: 15px;
  color: white;
  
}


/* Column container */
.row {  
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
}

/* Create two unequal columns that sits next to each other */
/* Sidebar/left column */
.side {
  -ms-flex: 30%; /* IE10 */
  flex: 30%;
  background-color: #f1f1f1;
  padding: 20px;
}

/* Main column */
.main {   
  -ms-flex: 70%; /* IE10 */
  flex: 70%;
  background-color: white;
  padding: 20px;
}


.fakeimg {
  background-color: white;
  width: 100%;
  padding: 20px;
  background-image: url('BMServ.jpg');
  background-repeat: no-repeat; /* Do not repeat the image */
  background-position: center; /* Center the image */
}


/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
  .row {   
    flex-direction: column;
  }
}

</style>

<body>

<div class="header">
  <div class="headerbackground" style="height:10px;"></div>
  <h1>BM Services</h1>
  <p>Beyond The Standard</p>
  <p2>Frederick Rd, Gillingham</p2>
</div>

<div class="main">
    <h2>Welcome to BM Services</h2>

    
    <h3>Today is, <span id='datetime'></span> </h3>
    

    <script>
        var dt = new Date();
        document.getElementById("datetime").innerHTML = (("0"+dt.getDate()).slice(-2)) +"."+ (("0"+(dt.getMonth()+1)).slice(-2)) +"."+ (dt.getFullYear())           +"";
    </script>

    
    

    <h2>Our Promise</h2>
    <div class="fakeimg" style="height:200px;"></div>
    <p>Customer satisfaction is the core of our car service and car repairs; therefore we are committed to ensuring that you get the best car service specials performance, reliability and enjoyment out of your car at the best possible price. We constantly improve our own efficiency, ensuring that we always source guaranteed parts at the best prices.</p>
    <br>

    <h2>About Us</h2>
    <div class="fakeimg" style="height:200px;"></div>
    <p>Add to this the fact that we only employ fully qualified technicians in our car repair workshop, plus our procedures are based on the latest international industry developments. You can trust us to do the best job at the best value for money with regards to an excellent vehicle service.</p>
  </div>
</div>

<div style="margin-left:2%;padding:0px;height:150px;">
    
</div>
</body>


<?php


include('includes/footer.html');
?>