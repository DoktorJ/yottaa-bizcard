<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>QR Code Generator</title>
</head>
<style type="text/css">
body {
  font-family: tahoma, sans-serif;
  font-size: 12pt;
}
div {
  position: static;
  margin: 4pt;
}
div:nth-of-type(even) {
  background: #eee;
}
label {
  position: relative;
  width: 150px;
  float: left;
}
input[type=text], input[type=checkbox] {
  position: relative;
  width: 300px;
  border: 1px solid #999;
  padding: 2pt;
  margin: 0pt;
}
input[type=checkbox] {
  width: 18px;
  height: 18px;
  padding: 0pt;
  margin: 3pt;
}
div:nth-of-type(even) input[type=text] {
  background:#eee;
}
span::before {
  content: "* ";
}
span {
  position: relative;
  color: #999;
  font-size: 10pt;
  margin-bottom: 4pt;
}
</style>
<body>
<form action="getqr.php" method="post">
<div>
  <label for="name">Name:</label>
  <input type="text" name="name" placeholder="John Doe"/>
  <span>Simply enter first name and last name in order</span>
</div>
<div>
  <label for="phone">Phone Number:</label>
  <input type="text" name="phone" placeholder="6178967800"/>
  <span>Enter all digits with no punctuation, e.g. 6178967800</span>
</div>
<div>
  <label for="email">Email Address:</label>
  <input type="text" name="email" placeholder="j.doe@yottaa.com"/>
</div>
<div>
  <label for="street">Street Address:</label>
  <input type="text" name="street" placeholder="100 5th Ave Fl 4"/>
  <span>Include suite/etc in this line if applicable</span>
</div>
<div>
  <label for="csz">City/State/Zip:</label>
  <input type="text" name="csz" placeholder="Waltham, MA, 02451"/>
  <span>Enter city, state, and zip code separated by commas</span>
</div>
<div>
  <label for="country">Country:</label>
  <input type="text" name="country" value="United States"/>
</div>
<div>
  <label for="url">LinkedIn URL:</label>
  <input type="text" name="url" placeholder="https://www.linkedin.com/in/johndoe"/>
  <span>Should begin with &quot;https://www.linkedin.com/in/&quot;</span>
</div>
<div>
  <label for="memo">Twitter/Note:</label>
  <input type="text" name="memo" placeholder="@JohnDoe"/>
  <span>This is an optional general-purpose note. You can put your Twitter handle here or anything else</span>
<div>
  <label style="width:auto;" for="omit">If you wish to omit the street address and city/state/zip, check this box:</label>
  <input type="checkbox" name="omit" value="1"/>
  <span style="bottom:4pt;">Otherwise leaving the Street Address or City/State/Zip fields blank will generate an error</span>
</div>
<br/>
<input type="submit"/>
</form>
</body>
</html>
