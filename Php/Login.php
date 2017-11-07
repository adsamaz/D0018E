<html>
    <style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #393939;
}

li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
    background-color: #16a426;
}

li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #16a426}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
</head>

<body>
    <ul>
  <li><a href="HtmlPage1.html">Home</a></li>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Store</a>
    <div class="dropdown-content">
      <a href="#">Product Typ 1</a>
      <a href="#">Product Typ 2</a>
      <a href="#">Product Typ 3</a>

    </div>
  </li>
  <li><a href="#account">Account</a></li>
  <li style="float:right"><a href="Login.html">Login</a></li>
  <li style="float:right"><a href="Register.html">Register</a></li>
  <li style="float:right"><a href="Kundvagn.html">Kundvagn</a></li>


</ul>
    <form>
        <table width="30%" bgcolor="ffffff" align="center">

            <tr>
                <td colspan=4><center><font size=4><b>Login</b></font></center></td>
            </tr>

            <tr>
                <td>Username</td>
                <td><input type="text" size=25 name="username" style="width: 140px"></td>
                <td> Password:</td>
                <td><input type="Password" size=25 name="password"style="width: 140px"></td>
            </tr>

           <tr>
                <td><input type="submit" onclick="check(this.form)" value="Login"></td>
            </tr>

        </table>
    </form>
 

</body>
</html>
